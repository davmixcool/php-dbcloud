<?php

// path to composer autoloader
require '../vendor/autoload.php';

use PhpDbCloud\Compressors;
use PhpDbCloud\Config\Config;
use PhpDbCloud\Databases;
use PhpDbCloud\Filesystems;
use PhpDbCloud\Sync;

// build providers
$filesystems = new Filesystems\FilesystemProvider(Config::fromPhpFile('config/storage.php'));
$filesystems->add(new Filesystems\Awss3Filesystem());
$filesystems->add(new Filesystems\GcsFilesystem());
$filesystems->add(new Filesystems\DropboxV1Filesystem());
$filesystems->add(new Filesystems\DropboxV2Filesystem());
$filesystems->add(new Filesystems\FtpFilesystem());
$filesystems->add(new Filesystems\LocalFilesystem());
$filesystems->add(new Filesystems\SftpFilesystem());

$databases = new Databases\DatabaseProvider(Config::fromPhpFile('config/database.php'));
$databases->add(new Databases\MysqlDatabase());
$databases->add(new Databases\PostgresqlDatabase());

$compressors = new Compressors\CompressorProvider();
$compressors->add(new Compressors\GzipCompressor());
$compressors->add(new Compressors\NullCompressor());

// build manager
return new Sync($filesystems, $databases, $compressors);
