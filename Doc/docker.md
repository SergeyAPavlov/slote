# Docker: Модификация конфигурации сервисов docker-compose

Есть конфигурация сервисов docker-compose.yml, требующая
модификации. Необходимо:

- добавить в этот файл сервис где будет работать приложение
php
- переопределить сервис базы данных на mysql 8 не меняя
текущий файл
- объединить все сервисы в одну сеть
- настройки портов и конфигурация сервиса nginx default.conf
должны изменяться извне
```yaml

version: '3'
    services:
    nginx:
        image: nginx:alpine
        container_name: app-nginx
        ports:
            - "8090:8090"
            - "443:443"
        volumes:
          - ./:/var/www
    db:
        platform: linux/x86_64
        image: mysql:5.6.47
        container_name: app-db
        ports:
          - "3306:3306"
        volumes:
            - ./etc/infrastructure/mysql/my.cnf:/etc/mysql/my.cnf
            - ./etc/database/base.sql:/docker-entrypoint-initdb.d/base.sql
```
## Ответ:

docker-compose.yml:
```yaml
---
version: '3'
services:
    nginx:
        image: nginx:alpine
        container_name: app-nginx
        ports:
            - "8090:8090"
            - "443:443"
        volumes:
            - ./:/var/www
            - ./etc/infrastructure/nginx:/etc/nginx
        networks:
            - net
    php:
        image: php:stable
        volumes:
          - ./:/var/www
        ports: []  # add xdebug port if needed
        networks: 
          - net
    db:
        platform: linux/x86_64
        image: mysql:5.6.47
        container_name: app-db
        ports:
            - "3306:3306"
        volumes:
            - ./etc/infrastructure/mysql/my.cnf:/etc/mysql/my.cnf
            - ./etc/database/base.sql:/docker-entrypoint-initdb.d/base.sql
        networks:
            - net
networks: 
    net:
```
docker-compose-update.yml
```yaml
---
version: '3'
services:
    db:
        platform: linux/x86_64
        image: mysql:8
        container_name: app-db
        ports:
            - "3306:3306"
        volumes:
            - ./etc/infrastructure/mysql/my.cnf:/etc/mysql/my.cnf
            - ./etc/database/base.sql:/docker-entrypoint-initdb.d/base.sql
        networks: 
            - net
```

запускать:
docker-compose -f docker-compose.yml -f docker-compose-update.yml up -d