# Development
Here you will find the requirements to starting this docker development. This readme is going to be writen with examples
from Windows OS.

## Requirements
- [Docker for Windows](https://store.docker.com/editions/community/docker-ce-desktop-windows)
- Terminal

## Setup
Open docker-compose.yml and change the following 2 lines, line 10 and line 18 `- .:/var/www/` to `- ../:/var/www/` or to the
directory where your code will be.

Start Docker for Windows and go into development-server dir in your terminal of choice and run the following

```
$  docker-compose up -d
```

This will build and start the docker stack it will take about 10 mins until it downloads and builds the stack for the first
time.

After everything is finished you can make an index.html in your choosen directory and go to `localhost:8000` and you should 
see the index.html loaded.

## Usage

- Web server is on `localhost:8000`
- Phpmyadmin is on `localhost:8080`
