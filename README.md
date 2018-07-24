# PHP-DBCLOUD

PHP-DBCLOUD is a php library that creates backup of your PostgreSql / MySql database and uploads it to the cloud. It also support restoring of the backedup database from the cloud.


[![GitHub license](https://img.shields.io/github/license/davmixcool/php-dbcloud.svg)](https://github.com/davmixcool/php-dbcloud/blob/master/LICENSE) 
[![GitHub issues](https://img.shields.io/github/issues/davmixcool/php-dbcloud.svg)](https://github.com/davmixcool/php-dbcloud/issues)
[![StyleCI](https://github.styleci.io/repos/142026911/shield?branch=master)](https://github.styleci.io/repos/142026911)
[![Coverage Status](https://coveralls.io/repos/github/davmixcool/php-dbcloud/badge.svg?branch=master)](https://coveralls.io/github/davmixcool/php-dbcloud?branch=master)


## Features

* Creating backups
 	* MySQL
 	* PostgreSQL

* Compress backups
 	* gZip

* Sync backups to other locations
 	* Amazon s3
 	* Dropbox
	* Google Cloud Storage
 	* FTP
 	* SFTP

## Requirements

- PHP 5.5
- MySQL support requires `mysqldump` and `mysql` command-line binaries
- PostgreSQL support requires `pg_dump` and `psql` command-line binaries
- Gzip support requires `gzip` and `gunzip` command-line binaries

## Steps:

* [Install](#install)
* [Configuration](#configuration)
	* [Configure your databases](#configure-your-databases)
	* [Configure your filesystems](#configure-your-filesystems)
* [Usage](#usage)
	* [Bootstrap the package](#bootstrap-the-package)
	* [Backup to configured database](#backup-to-configured-database)
	* [Restore from configured database](#restore-from-configured-database)
* [Example](#example)

### Install

**Composer**

Run the following to include this via Composer

```shell
composer require davmixcool/php-dbcloud
```

Then, you'll need to select the appropriate packages for the adapters that you want to use.

```shell
# to support Amazon s3
composer require league/flysystem-aws-s3-v3

# to support Dropbox (api v1)
composer require srmklive/flysystem-dropbox

# to support Dropbox (api v2)
composer require srmklive/flysystem-dropbox-v2

# to support Google Cloud Storage
composer require league/flysystem-aws-s3-v2

# to support Sftp
composer require league/flysystem-sftp
```

### Configuration

#### Configure your databases

```php
//config/database.php

return [

    'development' => [
        'type' => 'mysql',
        'host' => 'localhost',
        'port' => '3306',
        'user' => 'root',
        'pass' => 'password',
        'database' => 'test',
        // If singleTransaction is set to true, the --single-transcation flag will be set.
        'singleTransaction' => false,
        // Do not dump the given tables
        // Set only table names, without database name
        // Example: ['table1', 'table2']
        // http://dev.mysql.com/doc/refman/5.7/en/mysqldump.html#option_mysqldump_ignore-table
        'ignoreTables' => [],
        // using ssl to connect to your database - active ssl-support (mysql only):
        'ssl'=>false,
        // add additional options to dump-command (like '--max-allowed-packet')
        'extraParams'=>null,
    ],
    'production' => [
        'type' => 'postgresql',
        'host' => 'localhost',
        'port' => '5432',
        'user' => 'postgres',
        'pass' => 'password',
        'database' => 'test',
    ],
]
```


#### Configure your filesystems

```php
// config/storage.php
return [

    'local' => [
        'type' => 'Local',
        'root' => '/path/to/working/directory',
     ],
    's3' => [
        'type' => 'AwsS3',
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
        'version' => 'latest',
        'bucket' => '',
        'root'   => '',
    ],
    'gcs' => [
        'type' => 'Gcs',
        'key'    => '',
        'secret' => '',
        'version' => 'latest',
        'bucket' => '',
        'root'   => '',
    ],
    'dropbox-v2' => [
        'type' => 'DropboxV2',
        'token' => '',
        'key' => '',
        'secret' => '',
        'app' => '',
        'root' => '',
    ],
    'dropbox-v1' => [
        'type' => 'DropboxV1',
        'token' => '',
        'key' => '',
        'secret' => '',
        'app' => '',
        'root' => '',
     ],
    'ftp' => [
        'type' => 'Ftp',
        'host' => '',
        'username' => '',
        'password' => '',
        'root' => '',
        'port' => 21,
        'passive' => true,
        'ssl' => true,
        'timeout' => 30,
    ],
    'sftp' => [
        'type' => 'Sftp',
        'host' => '',
        'username' => '',
        'password' => '',
        'root' => '',
        'port' => 21,
        'timeout' => 10,
        'privateKey' => '',
    ],
]
```


### Usage

Once installed, the package must be bootstrapped with initial configurations before it can be used. 

#### Bootstrap the package

```php

use PhpDbCloud\Config\Config;
use PhpDbCloud\Filesystems;
use PhpDbCloud\Databases;
use PhpDbCloud\Compressors;
use PhpDbCloud\Sync;

// build providers
$filesystems = new Filesystems\FilesystemProvider(Config::fromPhpFile('config/storage.php'));
$filesystems->add(new Filesystems\Awss3Filesystem); 
$filesystems->add(new Filesystems\GcsFilesystem); 
$filesystems->add(new Filesystems\DropboxV1Filesystem); 
$filesystems->add(new Filesystems\DropboxV2Filesystem); 
$filesystems->add(new Filesystems\FtpFilesystem); 
$filesystems->add(new Filesystems\LocalFilesystem);
$filesystems->add(new Filesystems\SftpFilesystem); 

$databases = new Databases\DatabaseProvider(Config::fromPhpFile('config/database.php'));
$databases->add(new Databases\MysqlDatabase);
$databases->add(new Databases\PostgresqlDatabase);

$compressors = new Compressors\CompressorProvider;
$compressors->add(new Compressors\GzipCompressor);
$compressors->add(new Compressors\NullCompressor);

// build sync
return new Sync($filesystems, $databases, $compressors);

```

#### Backup to configured database

Backup the development database to `Dropbox Api V2`. The Dropbox backup path will be `test/backup.sql.gz` in the end, when `gzip` is done with it.


```php
use PhpDbCloud\Filesystems\Destination;

$sync = require 'bootstrap.php';
$sync->makeBackup()->run('development', [new Destination('dropbox-v2', 'test/backup.sql')], 'gzip');
```

#### Restore from configured database

Restore the database file `test/backup.sql.gz` from `Dropbox Api V2` to the `development` database.

```php
$sync = require 'bootstrap.php';
$sync->makeRestore()->run('dropbox-v2', 'test/backup.sql.gz', 'development', 'gzip');
```

> This package does not allow you to backup from one database type and restore to another. A MySQL dump is not compatible with PostgreSQL.


### Example

See Example [here](https://github.com/davmixcool/php-dbcloud/tree/master/example).


### Maintainers

This package is maintained by [David Oti](http://fb.me/davmixcool) and you!

### License

This package is licensed under the [MIT license](https://github.com/davmixcool/php-dbcloud/blob/master/LICENSE).