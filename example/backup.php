<?php

use PhpDbCloud\Filesystems\Destination;

$sync = require 'bootstrap.php';
$sync
    ->makeBackup()
    ->run('development', [
        new Destination('dropbox-v2', 'test/dump.sql')
    ], 'gzip');
