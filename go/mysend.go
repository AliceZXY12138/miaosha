package main

import (
	"log"
	"github.com/streadway/amqp"
	"encoding/json"
	"fmt"
	"io"
	"net/http"
	
	//"errors"
	//"gorm.io/driver/mysql"
	//"gorm.io/gorm"
	//"strconv"
	//"io/ioutil"
)
//Ret ...
type Ret struct {
	Code int    `json:"code,int"`
	Data string `json:"data"`
}

func failOnError(err error, msg string) {
	if err != nil {
		log.Fatalf("%s: %s", msg, err)
	}
}

func send(msg string){
	conn, err := amqp.Dial("amqp://root:18273645@101.37.13.45:5672/")
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

	//body := "test"
	//body := "{\"sno\": [\"2001210111\",\"2001210112\",\"2001210113\",\"2001210114\"],\"building_id\": \"3\",\"gender\": \"男\",\"count\": \"1\"}"
	body := msg

	err = ch.Publish(
		"",     // exchange
		q.Name, // routing key
		false,  // mandatory
		false,  // immediate
		amqp.Publishing{
			//ContentType: "text/plain",
			ContentType: "application/json",
			Body:        []byte(body),
			//Body:        body,
		})
	
	log.Printf(" [x] Sent %s", body)
	failOnError(err, "Failed to publish a message")
}

func printRequest(w http.ResponseWriter, r *http.Request) {
	ret := new(Ret)
	ret.Code = 200
	ret.Data = "提交成功"
	w.Header().Set("Content-Type", "application/json; charset=utf-8")
	retJSON, _ := json.Marshal(ret)
	io.WriteString(w, string(retJSON))
}

func getInfo(w http.ResponseWriter, r *http.Request) string{
	fmt.Println("r.Form=", r.Form) 
	/*for k, v := range r.Form {
		fmt.Println(k, v)
	}*/
	mjson,_ :=json.Marshal(r.Form)
	return string(mjson)
}

func miaosha(w http.ResponseWriter, r *http.Request) {
	r.ParseForm() //解析参数，默认是不会解析的
	mp := getInfo(w, r)
	printRequest(w, r)
	send(mp)
	//mp to json
	//send(body)

}

func main() {
	http.HandleFunc("/api/miaosha/order", miaosha) //设置访问的路径
	err := http.ListenAndServe(":8080", nil)    //设置监听的端口
	if err != nil {
		log.Fatal("ListenAndServe: ", err)
	}
}