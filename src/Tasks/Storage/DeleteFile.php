<?php namespace PhpDbCloud\Tasks\Storage;

use League\Flysystem\Filesystem;
use PhpDbCloud\Tasks\Task;

/**
 * Class DeleteFile
 * @package PhpDbCloud\Tasks\Storage
 */
class DeleteFile implements Task {

    /** @var Filesystem */
    private $filesystem;
    /** @var string*/
    private $filePath;

    /**
     * @param Filesystem $filesystem
     * @param $filePath
     */
    public function __construct(Filesystem $filesystem, $filePath) {
        $this->filesystem = $filesystem;
        $this->filePath = $filePath;
    }

    /**
     * @return bool
     */
    public function execute() {
        return $this->filesystem->delete($this->filePath);
    }
}
