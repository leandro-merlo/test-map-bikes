# application-citybik-integration-test

## Do not Fork, just Clone !!!

## Challenge

Make an application that has integration with the CityBikes API https://api.citybik.es/v2/ following requirements

### 1) Store only the necessary data in the Database

### 2) The user can view all access points in Brazil
Interface: Table of Shared Bicycle Points available in Brazil
Columns:
  - Place Name
  - Location (City / Country)
  - Number of Bicycles available
  
### 3) User can search by name or city
Interface: Table search results, puts only what you think necessary the user

### 4) Bonus: Find the nearest location
Interface: Table search results, puts only what you think necessary the user


## Tech
  - Use Docker and Docker-compose
  - Choose your Stack:
    - Stack PHP: Laravel framework
    - Stack Node: Express or Adonis framework
  - Database: PostgreSQL / MySql
  - Front: Bootstrap v3.x.x / JQuery / Vue.js / Angular2 / React
  

## Build and Run
- Clone from your git or fork

```sh
$ docker-compose build
$ docker-compose up -d
$ docker-compose exec app bash -c /tmp/after-start.sh
```
- Access ```localhost:8000```

