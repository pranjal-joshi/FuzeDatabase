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

As the server is intended to collect large amount of data from assembly line, Please modify the following configuration from ```/path/to/xampp/php/php.ini```