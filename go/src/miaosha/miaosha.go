package miaosha

import (
	"fmt"
	//"errors"
	//"gorm.io/driver/mysql"
	"gorm.io/gorm"
	"strconv"
	"time"
)

type Good struct {
	ID          int    	`gorm:"primaryKey"`
	GoodID  	int   	`gorm:"column:good_id"`
	Goodname 	string 	`gorm:"column:goodname"`
	Image 		string 	`gorm:"column:image"`
	Description	string 	`gorm:"column:description"`
	Stock 		int 	`gorm:"column:stock"`
	Sold		int 	`gorm:"column:sold"`
	Status 		int 	`gorm:"column:status"`
}


func Miaosha(mp map[string]interface{},db *gorm.DB) {
	isok := 1
	good_id := mp["good_id"].([]interface{})[0].(string)
	num,_ := strconv.Atoi(mp["num"].([]interface{})[0].(string))
	username := mp["username"].([]interface{})[0].(string)
	time := time.Now().Unix()   

	// 开始事务
	tx := db.Begin()

	good := []Good{}
	db.Table("goods").Where("good_id = ?", good_id).Where("stock > ?", num).Where("status = ?", 1).Find(&good)
	
	isok = 0
	if(len(good)==1){
		isok=1
	}
	

	if isok == 1 {
		
		db.Table("goods").Where("good_id = ?", good_id).Updates(
			map[string]interface{}{
				"stock": good[0].Stock-num,
				"sold": good[0].Sold+num })
		db.Table("orders").Create(
			map[string]interface{}{
				"customer_name": username, 
				"good_id": good_id,
				"num": num,
				"time": time })
		fmt.Println("用户",username,"成功购买", num,"件",good_id)
	} else {
		// 如果未找到
		fmt.Println("购买失败")
	}

	// 否则，提交事务
	tx.Commit()

	
}