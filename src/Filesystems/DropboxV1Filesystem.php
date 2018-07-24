<?php namespace PhpDbCloud\Filesystems;

use League\Flysystem\Dropbox\DropboxAdapter;
use Dropbox\Client;
use League\Flysystem\Filesystem as Flysystem;

/**
 * Class DropboxV1Filesystem
 * @package PhpDbCloud\Filesystems
 */
class DropboxV1Filesystem implements Filesystem {

    /**
     * Test fitness of visitor.
     * @param $type
     * @return bool
     */
    public function handles($type) {
        return strtolower($type) == 'dropboxv1';
    }

    /**
     * @param array $config
     * @return Flysystem
     */
    public function get(array $config) {
        $client = new Client($config['token'], $config['app']);
        return new Flysystem(new DropboxAdapter($client, $config['root']));
    }
}
