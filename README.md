# Phalcon RESTful API Micro Service 

This is a RESTful API micro service based on Phalcon framework.

***

## 目录结构

```bash
$ tree -d -L 2 -I vendor
.
├── config 配置目录
├── src 应用目录
│   ├── components 组件
│   ├── controllers 控制器
│   ├── events 事件
│   ├── exceptions 异常
│   ├── migrations 迁移
│   ├── models 模型
│   ├── validations 验证
│   └── views 视图
├── tmp 缓存目录
│   ├── cache 缓存
│   └── logs 日志
└── webroot 入口目录
    ├── css 样式
    ├── files 文件
    ├── img 图片
    └── js 脚本

18 directories
```

## 项目配置

### 运行配置文件

将 `config/config.default.ini` 重命名为 `config/config.ini`

#### `application` - 应用程序配置

#### `database` - 数据库配置

#### `security` - 安全配置

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

## Create skeleton

### Create controller

```bash
$ phalcon controller --name default --namespace App\\Controller --output=./src/controllers --force
```

### Create model 

```bash
$ phalcon model --name=users --namespace=App\\Model --output=./src/models --get-set --doc --trace --camelize --mapcolumn --annotate --force
```

### Create migration

```bash
// Initial migration
$ phalcon migration --action=generate --descr=init --force
```
