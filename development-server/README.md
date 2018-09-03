# Development

Here you will find the requirements to starting this docker development. This readme is going to be writen with examples
from Windows OS.

## Requirements

- [Docker for Windows](https://store.docker.com/editions/community/docker-ce-desktop-windows)
- Terminal

## Setup

Open docker-compose.yml and change the following 2 lines, line 10 and line 18 `- .:/var/www/` to `- ../www:/var/www/` or to the
directory where your code will be.

Start Docker for Windows and go into development-server dir in your terminal of choice and run the following

```
$  docker-compose up -d
```

This will build and start the docker stack it will take about 10 mins until it downloads and builds the stack for the first
time.

After everything is finished go to `localhost:8090`, you should see an "Welcome to CodeIgniter!" page.

## Usage

- Web server is on `localhost:8090`
- Phpmyadmin is on `localhost:8091`
