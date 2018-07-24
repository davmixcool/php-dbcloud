<?php

namespace PhpDbCloud\Procedures;

use PhpDbCloud\Compressors\CompressorProvider;
use PhpDbCloud\Databases\DatabaseProvider;
use PhpDbCloud\Filesystems\FilesystemProvider;
use PhpDbCloud\ShellProcessing\ShellProcessor;

/**
 * Class Procedure.
 */
abstract class Procedure
{
    /** @var FilesystemProvider */
    protected $filesystems;
    /** @var DatabaseProvider */
    protected $databases;
    /** @var CompressorProvider */
    protected $compressors;
    /** @var ShellProcessor */
    protected $shellProcessor;

    /**
     * @param FilesystemProvider $filesystemProvider
     * @param DatabaseProvider   $databaseProvider
     * @param CompressorProvider $compressorProvider
     * @param ShellProcessor     $shellProcessor
     *
     * @internal param Sequence $sequence
     */
    public function __construct(FilesystemProvider $filesystemProvider, DatabaseProvider $databaseProvider, CompressorProvider $compressorProvider, ShellProcessor $shellProcessor)
    {
        $this->filesystems = $filesystemProvider;
        $this->databases = $databaseProvider;
        $this->compressors = $compressorProvider;
        $this->shellProcessor = $shellProcessor;
    }

    /**
     * @param $name
     * @param null $filename
     *
     * @throws \PhpDbCloud\Config\ConfigNotFoundForConnection
     *
     * @return string
     */
    protected function getWorkingFile($name, $filename = null)
    {
        if (is_null($filename)) {
            $filename = uniqid();
        }

        return sprintf('%s/%s', $this->getRootPath($name), $filename);
    }

    /**
     * @param $name
     *
     * @throws \PhpDbCloud\Config\ConfigFieldNotFound
     * @throws \PhpDbCloud\Config\ConfigNotFoundForConnection
     *
     * @return string
     */
    protected function getRootPath($name)
    {
        $path = $this->filesystems->getConfig($name, 'root');

        return preg_replace('/\/$/', '', $path);
    }
}
