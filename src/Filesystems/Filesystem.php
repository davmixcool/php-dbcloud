<?php

namespace PhpDbCloud\Filesystems;

/**
 * Interface Filesystem.
 */
interface Filesystem
{
    /**
     * Test fitness of visitor.
     *
     * @param $type
     *
     * @return bool
     */
    public function handles($type);

    /**
     * @param array $config
     *
     * @return \League\Flysystem\Filesystem
     */
    public function get(array $config);
}
