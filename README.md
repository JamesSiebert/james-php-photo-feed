# Basic Image Uploader

##### Using PHP Only 

By James Siebert



#### Project source code

GitHub - https://github.com/JamesSiebert/james-php-photo-feed

**Deployment info**
SQL migration file /migration.sql
ENV for DB params /config/.env

------

#### Improvements on my work

- README.md is unfinished and rough.
- Need to do further research into PSR so I write cleaner more standardised code - https://www.php-fig.org/psr/psr-2/
- I need to research the specific permissions required on each file for deployment
- Break code into smaller pieces.
- Use .htaccess to redirect to /public/
- Provide more detailed error feedback

#### Future expansion and security considerations

- The images table was intended to allow us to handle multiple resolution variations and image specific info.
- Pagination should be used.

- Too many requests - implement throttling.
- DDOS protection
- Script execution time limits





------

### Deployment

Launch EC2 Instance

[LAMP on CentOS 7 by Classmethod product detail page on AWS Marketplace](http://aws.amazon.com/marketplace/pp/B09C7GKY4V?ref=cns_srchrow)

https://cloudcookie.info/docs/aws-documentation/aws-lamp-on-centos-7/

This LAMP Stack provides a ready to use and stable LAMP development environment optimized for CentOS 7, featuring Apache 2.4, Maria DB 10.6, PHP 7.4 and phpMyAdmin 5.1.1.



#### MySQL setup

get DB credentials

```
cat /home/centos/credentials
```

```
////////////////////credentials info////////////////////
--- phpMyAdmin
----- Setting  : Success
--- MariaDB
----- User     : root
----- Password : abc123
////////////////////////////////////////////////////////
```

edit /config/.env

```
mysql --host=localhost --user=root --password=
CREATE DATABASE james_php_photo_feed;
quit
```

exit mysql

```
mysql -u root -p james_php_photo_feed < /var/www/html/migration.sql
quit
```

confirm data exists

```
mysql --host=localhost --user=root --password=
SHOW TABLES FROM james_php_photo_feed;
quit
```

```
mysql --host=localhost --user=root --password= james_php_photo_feed
SELECT * FROM posts;
SELECT * FROM posts;
quit
```



Composer install for UUID and dotenv packages

```
composer install
```



## Dev Notes

#### .htaccess

.htaccess redirect (tested on local)

```php
# Redirect
# site.com/index.php links to site.com/public/index.php

RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(?!public/(?:index\.php)?$) /public/index.php [L]
```

#### Apache Permissions

-- Needs checking

chmod 755 -R /var/www/html/

For: models, api, public/image, public, config(required)
