<?php

$sync = require 'bootstrap.php';
$sync->makeRestore()->run('dropbox-v2', 'test/backup.sql.gz', 'development', 'gzip');
