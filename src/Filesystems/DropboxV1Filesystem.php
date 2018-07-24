<?php

namespace PhpDbCloud\Filesystems;

use Dropbox\Client;
use League\Flysystem\Dropbox\DropboxAdapter;
use League\Flysystem\Filesystem as Flysystem;

/**
 * Class DropboxV1Filesystem.
 */
class DropboxV1Filesystem implements Filesystem
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
        return strtolower($type) == 'dropboxv1';
    }

    /**
     * @param array $config
     *
     * @return Flysystem
     */
    public function get(array $config)
    {
        $client = new Client($config['token'], $config['app']);

        return new Flysystem(new DropboxAdapter($client, $config['root']));
    }
}
