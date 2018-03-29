# FuzeDatabase

Online platform of Fuze department for storing information such as test records, test results and to perform required analytics or monitor the assembly processes for minimal rejection or efficient production.

## Getting Started

### Prerequisites

Make sure you have following/equivalent environment installed to host FuzeDatabase server.

The current configuration of server is as follow: (Feel free to use upgraded versions, if available)

```
XAMPP (V.3.2.2 or above)
|
|--Apache Webserver V.2.4
|
|--PHP V.7.2.2
|
|--MariaDB V.10.1.30

```

Above configurations can be manually installed irrespective of any operating system. Or you can use XAMPP control panel which provides all above softwares bundled together.

### Setup

After successful installation of above environment, clone the repository into
```
path/to/xampp/htdocs/FuzeDatabase
```

As the server is intended to collect large amount of data from assembly line, Please modify the configuration as given below:
```
/path/to/xampp/php/php.ini

post_max_size=256M
upload_max_filesize=256M
memory_limit=256M

```

After changing password for root user of the database, modify following file to allow access to connect the database.
```
/path/to/xampp/PhpMyAdmin/config.inc.php

$cfg['Servers'][$i]['user'] = '**your_root_username**';
$cfg['Servers'][$i]['password'] = '**your_root_passwd**';
```

### Initialize

To make the web & database server to start automatically, you have to add it as a startup service.

If you are linux based, then Apache2 and MySQL are usually configured their daemons to start after boot so you don't need to worry about it unless you mess up with the configuration settings.

If you are windows based, Run XAMPP control panel with Administrator rights and then add Apache & MySQL to startup services by clicking on the respective checkboxes in xampp control panel. Alternatively, you can run "services.msc" with run command to configure startup services manually.