<?php

$sync = require 'bootstrap.php';
$sync->makeRestore()->run('s3', 'test/backup.sql.gz', 'mysql', 'gzip');
