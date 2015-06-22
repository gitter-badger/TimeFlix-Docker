# TimeFlix-Docker

[![Join the chat at https://gitter.im/Peanuts/TimeFlix-Docker](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/Peanuts/TimeFlix-Docker?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

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

