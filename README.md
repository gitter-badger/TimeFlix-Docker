# TimeFlix-Docker

### Install
```sh
  apt-get install docker-io
  docker pull kouja/timeflix
  docker run -d -p 8000:80 -p 2200:22 kouja/timeflix
```
Not compatible for arm version ! 

### Login

User : root / 
Pass : timeflix 

Change your root login ! 

1. Update TimeFlix

```sh
nohup php index.php encodage > logs/system.log &
```

2. Run encodage service manuely

```sh
nohup php index.php encodage > logs/system.log &
```
### Go 

WebInteface -> http://0.0.0.0:8000 and configure your administrator login. 


