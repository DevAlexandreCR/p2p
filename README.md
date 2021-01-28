# P2P

P2P is an online store developed with PHP 7.4, Laravel 7+ and Vue 2.

### Features

- Admins management
- Admins roles management
- Integrated with payment gateway [PlaceToPay](https://www.placetopay.com/web/)
- Showcase
- Users register
- Cart management
- More...

## Requirements

- PHP 7.4+ `required`
- Mysql 5.7+ `required`
- Node 8+
- Redis to cache, session and queued jobs  `optional`

## Installation

- Clone repository `git clone https://github.com/DevAlexandreCR/lokerstore`
- Use the package manager [composer](https://getcomposer.org/download/) and [npm](https://nodejs.org/es/) to install.

```bash
- cd p2p
- composer install
- npm install
```

## Environment

- ##### Install stack Linux, Apache, MySQL and PHP
  Look this tutorial to install your environment [(LAMP)](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-on-ubuntu-20-04-es#paso-1-instalar-apache-y-actualizar-el-firewall)  
  Open mysql and create databases to project, make sure CHARACTER SET utf8 COLLATE utf8_unicode_ci is added
    ```bash
        - mysql -p
        Enter password: your_passsword
        mysql> CREATE DATABASE lokerstore CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        mysql> CREATE DATABASE testing CHARACTER SET utf8 COLLATE utf8_unicode_ci;
        mysql> GRANT ALL ON lokerstore.* TO 'your_user'@'%';
        mysql> GRANT ALL ON testing.* TO 'your_user'@'%';
        mysql> exit
    ```
- ##### Docker - [laradock](http://laradock.io/)
    1. Clone Laradock inside p2p project:
       ```bash
       - git submodule add https://github.com/Laradock/laradock.git
       ```  
    2. Enter the laradock folder and rename env-example to .env.
        ```bash
           - cd laradock
           - cp env-example .env 
        ``` 
    3. Open laradock’s .env file and set the following:
       ```bash
           PHP_VERSION=7.4
           WORKSPACE_INSTALL_SUPERVISOR=true
           MYSQL_VERSION=latest
           MYSQL_DATABASE=default
           MYSQL_USER=your_user
           MYSQL_PASSWORD=your_user_password
           MYSQL_PORT=3306
           MYSQL_ROOT_PASSWORD=your_root_password
       ```
    4. Run containers:
        ```bash
           - docker-compose up -d nginx mysql redis workspace
        ```
    5. Enter inside mysql container and create the testing and project database:
        ```bash
            - docker-compose exec mysql bash
            - mysql -p
            Enter password: your_passsword
            mysql> CREATE DATABASE testing;
            mysql> GRANT ALL ON testing.* TO 'your_user'@'%';
            mysql> exit
        ```
    6. Enter inside workspace container and give permission:
        ```bash
           - docker-compose exec workspace bash
           - chmod -R 777 /var/www
           - composer install
           - npm install      
        ```
    7. Open p2p’s .env file and set the following:
        ```bash
            DB_HOST=mysql
            REDIS_HOST=redis
            QUEUE_CONNECTION=redis
            REDIS_CLIENT=phpredis
        ```  
## Configuration
Copy file `.env.example` in `.env` file and customize your environment to database, mail, cache, etc.

- In linux
```bash
- cp .env.example .env
```
- In windows
```powershell
- copy .env.example .env
```
- Environment variables.   
  `DB_HOST` your database host
  `DB_DATABASE` your database name
  `DB_USERNAME` your database username
  `DB_PASSWORD` your database password
  `APP_EMAIL_SUPPORT` email to show clients.   
  `MAIL_HOST`  your mail host example `smtp.mailtrap.io`.   
  `MAIL_USERNAME`  mail username.   
  `MAIL_PASSWORD`  mail password.   
  `LOG_SLACK_WEBHOOK_URL` Url to webhook to slack notifications logs.   
  `P2P_BASE_URL` Url to payments gateway API [PlaceToPay](https://www.placetopay.com/web/)  
  `P2P_SECRET_KEY` Required to gateway authentication     
  `P2P_AUTH` Required to gateway authentication  
  `P2P_TIMEOUT` Max time out to gateway responses  
  `CACHE_DRIVER` This value **can't** be file, because cache required `tags`
  `MIX_APP_MAX_PRICE` Max product price to accept store.

- Run scripts
```bash
- php artisan key:generate
- php artisan migrate --seed
- npm run prod 
- php artisan storage:link --relative
```
- To test app  
  Make sure to create testing database en set vars inside `.env.testing`
```bash
- cp .env.example .env.testing
- php artisan test
```
- Create super-admin user
```bash
- php artisan admin:create
```
- To test store with fake data
```bash
- php artisan db:seed --class=DummyDatabaseSeeder
- php artisan optimize:clear
- php artisan serve
```
- To execute schedule tasks like query payments, query metrics and automatics reports
```bash
- php artisan schedule:run
```

- This app use queued jobs to send emails to users about payments, to send emails to admins      
  about monthly reports, to generate customized reports, to query status payments to API PlaceToPay  
  and more, make sure to run `php artisan queue:work`
  ##### Installing Supervisor
  Supervisor is a process monitor for the Linux operating system, and will automatically  
  restart your `queue:work` process if it fails. To install Supervisor on Ubuntu, you may use  
  the following command: `sudo apt-get install supervisor`  
  For more information on Supervisor, consult the [Supervisor documentation](http://supervisord.org/index.html).
  
## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)
