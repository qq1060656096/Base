安装(Install)
=========================

1步 通过Composer安装
-------------------------
> 通过 Composer 安装
如果还没有安装 Composer，你可以按 [getcomposer.org](https://getcomposer.org/) 中的方法安装


2步 创建composer写入内容
-------------------------
> 创建composer.json文件,并写入以下内容

```json
{
  "require": {
    "zwei/base": "dev-develop"
  }
}
```


3步 安装
-------------------------
```php
composer install
```

4步 在项目目录创建config/bao-loan.yml文件,添加一下内容
-------------------------

```yml
BASE_TEST_CONFIG: "base_test_config" # 本包测试键（单元测试用）

# 数据库配置
DB_HOST: "localhost" # 主机
DB_PORT: 3306 # 端口
DB_USER: "root" # 用户名
DB_PASS: "root" # 密码
DB_NAME: "demo" # 数据库名
DB_TABLE_PREFIX: "" # 表前缀
DB_CHARSET: "utf8" # 设置字符编码,空字符串不设置
DB_SQLLOG: false # 是否启用sql调试
```
