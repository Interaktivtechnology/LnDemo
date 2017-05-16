# BreastCancerFoundation
This repository is made for Breast Cancer Foundation data loader.

## Server requirements:
* PHP Framework Yii2 Version with composer.
* PHP version 5.4 or later
* MySQL Server 5.5 or later
* TLS 1.1
* CURL Enabled
* SSL Enabled
* OpenSSL Enabled
* SOAP Enabled


## How to install
* Extract file to your web server folder
* ./web/ should be the endpoint that execute by webserver
* Execute ./schema.sql into your MySQL Server
* Change configuration of ./config/db.php
  * class : Yii2 configuration class, no need to change
  * dsn :
    * host : where mysql database is hosted
    * dbname : database name of the application
    * port  : which port number that mysql server currently using.
  * username: Mysql username credential
  * password: Mysql password credential
* Make ./temp folder writeable by webserver, this is used for excel file container.
* Change username and password for application credential in ./assets/users.json
* Test the web app


## Security Concern
* To make it secure, the connection can only be accessed from some ip range. Please consult to your web hosting provider.
* Enable the SSL certificate if necessary
