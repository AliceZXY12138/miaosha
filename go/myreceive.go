package main

import (
  	"log"
  	"github.com/streadway/amqp"
  	"encoding/json"
	"fmt"
	
	/*"errors"
	"strconv"*/
	"gorm.io/driver/mysql"
	"gorm.io/gorm"
	
	"miaosha"
)

func failOnError(err error, msg string) {
  	if err != nil {
    	log.Fatalf("%s: %s", msg, err)
  	}
}


func main(){
	conn, err := amqp.Dial("amqp://username:password@101.37.13.45:5672/")//设置rabbitMQ的账号密码
	failOnError(err, "Failed to connect to RabbitMQ")
	defer conn.Close()

	ch, err := conn.Channel()
	failOnError(err, "Failed to open a channel")
	defer ch.Close()

	q, err := ch.QueueDeclare(
	"miaosha", // name
	false,   // durable
	false,   // delete when unused
	false,   // exclusive
	false,   // no-wait
	nil,     // arguments
	)
	failOnError(err, "Failed to declare a queue")

	msgs, err := ch.Consume(
		q.Name, // queue
		"",     // consumer
		true,   // auto-ack
		false,  // exclusive
		false,  // no-local
		false,  // no-wait
		nil,    // args
	)
	failOnError(err, "Failed to register a consumer")
	  
	forever := make(chan bool)

	dsn := "username:password@tcp(localhost:3306)/miaosha?charset=utf8mb4&parseTime=True&loc=Local"//设置mysql的账号密码
	//连接数据库
	db, err := gorm.Open(mysql.Open(dsn), &gorm.Config{})
	if err != nil {
		fmt.Println(err)
	}

	go func() {
		for d := range msgs {
			log.Printf("Received a message: %s", d.Body)
		  	var jdata map[string]interface{}
			json.Unmarshal(d.Body, &jdata)
			
			miaosha.Miaosha(jdata,db)//封装的函数
		}
	}()
	  
	log.Printf(" [*] Waiting for messages. To exit press CTRL+C")
	<-forever
}
