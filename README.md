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

Update TimeFlix

```sh
cd /var/www/time/
git pull 
```

Run encodage service manuely

```sh
nohup php index.php encodage > logs/system.log &
```
### Go 

WebInteface -> http://0.0.0.0:8000 and configure your administrator login.

![2](https://cloud.githubusercontent.com/assets/533219/7962001/392e1a8c-0a0b-11e5-84ff-702be0e1702b.png)

Enjoy ! 

