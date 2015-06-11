# TimeFlix-Docker

### Install
```sh
  apt-get install docker.io
  docker pull kouja/timeflix
  docker run -d -p 8000:80 -p 2200:22 kouja/timeflix
```
Not compatible for arm version ! 

### Required
- Linux x64 
- APIKey "https://www.themoviedb.org/"

### Login

User : root / 
Pass : timeflix 

Change your root login ! 

Update TimeFlix

```sh
cd /var/www/time/
nano config/config.php >> and change key_crypt for security password
git pull 
```

Run encodage service manually

```sh
nohup php index.php encodage > logs/system.log &
```

### Go 

- http://0.0.0.0:8000  
- Configure your administrator login.

Enjoy ! 

