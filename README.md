# Phalcon RESTful API Micro Service 

This is a RESTful API micro service based on Phalcon framework.

***

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
