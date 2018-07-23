<?php namespace PhpDbCloud\Tasks\Compression;

use PhpDbCloud\Tasks\Task;
use PhpDbCloud\Compressors\Compressor;
use PhpDbCloud\ShellProcessing\ShellProcessor;

/**
 * Class DecompressFile
 * @package PhpDbCloud\Tasks\Compression
 */
class DecompressFile implements Task {

    /** @var string */
    private $sourcePath;
    /** @var ShellProcessor */
    private $shellProcessor;
    /** @var Compressor */
    private $compressor;

    /**
     * @param Compressor $compressor
     * @param $sourcePath
     * @param ShellProcessor $shellProcessor
     */
    public function __construct(Compressor $compressor, $sourcePath, ShellProcessor $shellProcessor) {
        $this->sourcePath = $sourcePath;
        $this->shellProcessor = $shellProcessor;
        $this->compressor = $compressor;
    }

    /**
     * @throws \PhpDbCloud\ShellProcessing\ShellProcessFailed
     */
    public function execute() {
        return $this->shellProcessor->process($this->compressor->getDecompressCommandLine($this->sourcePath));
    }
}
