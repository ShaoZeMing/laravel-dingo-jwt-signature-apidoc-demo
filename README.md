# laravel-dingo-jwt-signature-apidoc-demo
 - 获取方法：
 
 
 ```
 git clone https://github.com/ShaoZeMing/laravel-dingo-jwt-signature-apidoc-demo.git  myobject
 cd myobject/
 
 
 ```

- 配置文件

 ```
 cp .env.development .env
 composer install
 //修改 .env 配置文件 根据自己项目需要配置：

 
```
- 创建配置文件对应数据库后执行迁移文件

 ```
 //先创建对应数据库后执行
 php artisan migrate     //迁移生成几个基础表，用于测试，
 
 ```
- 配置apidoc 接口文档并生成接口文档
 
 ```
 cp apidoc_development.json apidoc.json
 vi apidoc.json    //修改接口api请求域名和当前项目配置一致，便于api请求测试

 npm install apidoc -g   //未安装apidoc  安装apidoc 
 apidoc -i app/Http/Controllers/ -o public/apidoc/    //生成接口文档

```

# demo测试地址

- 首页:http://laravel-demo.4d4k.com
- api文档:http://laravel-demo.4d4k.com/apidoc/
