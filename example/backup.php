<?php

use PhpDbCloud\Filesystems\Destination;

$sync = require 'bootstrap.php';
$sync
    ->makeBackup()
    ->run('mysql', [
        new Destination('local', 'test/backup.sql'),
        new Destination('s3', 'test/dump.sql')
    ], 'gzip');
