# miaosha
vue + elementUI + axios / thinkphp + X-admin / go

2020秋 互联网软件开发技术与实践 大作业

### 部署说明

#### thinkPHP
- 用PHP5.6，部署一个thinkphp站点，所有文件均在`thinkphp`文件夹中
- `application`中，`admin`为后台管理系统，`customer`为用户端

#### mySQL
- 创建名为miaosha的数据库，用`mysql/miaosha.sql`导入数据
- 在`thinkphp/application/database.php`中进行相应设置
- 用户名为root，密码为18273645

#### Go
- 用户端秒杀商品时使用`go`操作`rabbitMQ`，相关文件均在`go`文件夹中
- 安装、配置GO环境 / 生成可执行文件
- 运行`mysend.go`(需开放5000端口),`myreceive.go`

#### 其他
- 安装JWT
- 安装redis
- 安装rabbitMQ（用户名为root，密码为18273645）
- 开放5000、3306、6379、5672、15672等端口

