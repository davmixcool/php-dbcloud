<?php

use PhpDbCloud\Filesystems\Destination;

$sync = require 'bootstrap.php';
$sync
    ->makeBackup()
    ->run('mysql', [
        new Destination('dropbox', 'test/dump.sql')
    ], 'gzip');
