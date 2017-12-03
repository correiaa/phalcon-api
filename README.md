# Phalcon RESTful API Micro Service 

> * [Phalcon 官网](https://phalconphp.com/zh/)
> * [GitHub](https://github.com/phalcon/cphalcon/)

***

This is a RESTful API micro service based on Phalcon framework.

***

## 框架环境

基于 `Phalcon 3.2.2` 构建

## 目录结构

```bash
$ tree -L 2 -I vendor
.
├── LICENSE
├── README.md
├── composer.json
├── composer.lock
├── config -> 配置目录
│   ├── config.default.ini 配置文件
│   └── helper.php         函数文件
│   └── paths.php          路径文件
├── src -> 应用目录
│   ├── Bootstrap.php   引导
│   ├── components      组件
│   ├── controllers     控制器
│   ├── events          事件
│   ├── exceptions      异常
│   ├── helpers         助手(复用)
│   ├── migrations      迁移
│   ├── models          模型
│   ├── routes          路由
│   ├── tasks           任务(控制台)
│   └── validations     验证
├── tmp -> 缓存目录
│   ├── cache 缓存
│   └── logs  日志
└── webroot -> 入口目录
    ├── .htaccess   重写
    ├── favicon.ico 图标
    ├── files       文件
    ├── cli.php     命令行入口
    ├── debug.php   调试入口
    └── index.php   主入口
```

## 项目配置

### 运行配置文件

将 `config/config.default.ini` 重命名为 `config/config.ini`

#### `application` - 应用程序配置

| 配置键 | 配置值 | 说明 |
| --- | --- | --- |
| `isListenDb` | 可选的值: `0: 禁用, 1: 开启` | 开启后会记录运行的 `SQL` |
| `isToken` | 可选的值: `0: 禁用, 1: 开启` | 开启后会验证访问令牌 `TOKEN` |
| `isSign` | 可选的值: `0: 禁用, 1: 开启` | 开启后会验证数据签名 `SIGN` |
| `apiVersion` | `v1, v2, ...` | 接口版本 |
| `componentsDir` | `../src/components/` | 组件目录 |
| `controllersDir` | `../src/controllers/` | 控制器目录 |
| `eventsDir` | `../src/events/` | 事件目录 |
| `exceptions` | `../src/exceptions/` | 异常目录 |
| `helpersDir` | `../src/helpers/` | 助手(复用)目录 |
| `migrationsDir` | `../src/migrations/` | 迁移目录 |
| `modelsDir` | `../src/models/` | 模型目录 |
| `tasksDir` | `../src/tasks/` | 任务目录 |
| `validationsDir` | `../src/validations/` | 验证目录 |
| `baseUri` | `/phalcon-api/` | 根目录 |

#### `database` - 数据库配置

| 配置键 | 配置值 | 说明 |
| --- | --- | --- |
| `adapter` | `Mysql` | 数据库适配器, 些项目仅支持 `MySQL` |
| `host` | `ip address` | 数据库地址 |
| `username` | `username` | 数据库用户 |
| `password` | `password` | 数据库密码 |
| `dbname` | `dbname` | 数据库名称 |
| `charset` | `charset` | 数据库字符 |


#### `security` - 安全配置

| 配置键 | 配置值 | 说明 |
| --- | --- | --- |
| `appid` | `32 位 APP ID` | 应用 ID |
| `appsecret` | `64 位 APP SECRET` | 应用密钥 |

### 虚拟主机配置

```nginx
# phalcon-api

server {
    listen 80;
    server_name local.phalcon-api.com;

    root /YourWorkspace/phalcon-api/webroot;
    index index.php index.html index.htm;

    charset utf-8;
    client_max_body_size 100M;
    fastcgi_read_timeout 1800;

    access_log /usr/local/var/log/nginx/phalcon-api-access.log;
    error_log  /usr/local/var/log/nginx/phalcon-api-error.log;

    location / {
        try_files $uri $uri/ /index.php?_url=$uri&args;
    }

    location ~ \.php$ {
        try_files $uri =404;

        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index /index.php;

        include fastcgi.conf;
        fastcgi_split_path_info ^(.+\.php)(/.*)$;
        fastcgi_param PATH_INFO $fastcgi_path_info;
        fastcgi_param PATH_TRANSLATED $document_root$fastcgi_path_info;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTPS off;
    }

    location = /favicon.icon {
        log_not_found off;
        access_log off;
    }

    location ~ /(\.ht|\.git|\.svn) {
        deny all;
    }

    location ~* \.(jpg|jpeg|gif|png|ico|swf)$ {
        log_not_found off;
        access_log off;
        gzip off;
    }
}
```

## 框架命令

### 创建控制器 - `Create Controller`

```bash
$ phalcon controller --name default --namespace App\\Controller --output=./src/controllers --force
```

### 创建模型 - `Create Model` 

```bash
$ phalcon model --name=users --namespace=App\\Model --output=./src/models --get-set --doc --trace --camelize --mapcolumn --annotate --force
```

### 创建迁移 - `Create Migration`

```bash
// Initial migration
$ phalcon migration --action=generate --descr=init --force
```
