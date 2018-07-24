<?php

namespace PhpDbCloud\Filesystems;

use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Sftp\SftpAdapter;

/**
 * Class SftpFilesystem.
 */
class SftpFilesystem implements Filesystem
{
    /**
     * Test fitness of visitor.
     *
     * @param $type
     *
     * @return bool
     */
    public function handles($type)
    {
        return strtolower($type) == 'sftp';
    }

    /**
     * @param array $config
     *
     * @return Flysystem
     */
    public function get(array $config)
    {
        return new Flysystem(new SftpAdapter($config));
    }
}
