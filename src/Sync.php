<?php

namespace PhpDbCloud;

use PhpDbCloud\Compressors\CompressorProvider;
use PhpDbCloud\Databases\DatabaseProvider;
use PhpDbCloud\Filesystems\FilesystemProvider;
use PhpDbCloud\ShellProcessing\ShellProcessor;
use Symfony\Component\Process\Process;

/**
 * Class Sync.
 */
class Sync
{
    /** @var FilesystemProvider */
    private $filesystems;
    /** @var DatabaseProvider */
    private $databases;
    /** @var CompressorProvider */
    private $compressors;

    /**
     * @param \PhpDbCloud\Filesystems\FilesystemProvider $filesystems
     * @param \PhpDbCloud\Databases\DatabaseProvider     $databases
     * @param \PhpDbCloud\Compressors\CompressorProvider $compressors
     */
    public function __construct(FilesystemProvider $filesystems, DatabaseProvider $databases, CompressorProvider $compressors)
    {
        $this->filesystems = $filesystems;
        $this->databases = $databases;
        $this->compressors = $compressors;
    }

    /**
     * @return Procedures\BackupProcedure
     */
    public function makeBackup()
    {
        return new Procedures\BackupProcedure(
            $this->filesystems,
            $this->databases,
            $this->compressors,
            $this->getShellProcessor()
        );
    }

    /**
     * @return Procedures\RestoreProcedure
     */
    public function makeRestore()
    {
        return new Procedures\RestoreProcedure(
            $this->filesystems,
            $this->databases,
            $this->compressors,
            $this->getShellProcessor()
        );
    }

    /**
     * @return ShellProcessing\ShellProcessor
     */
    protected function getShellProcessor()
    {
        return new ShellProcessor(new Process('', null, null, null, null));
    }
}
