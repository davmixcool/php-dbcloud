<?php namespace PhpDbCloud\Tasks\Compression;

use PhpDbCloud\Tasks\Task;
use PhpDbCloud\Compressors\Compressor;
use PhpDbCloud\ShellProcessing\ShellProcessor;

/**
 * Class CompressFile
 * @package PhpDbCloud\Tasks\Compression
 */
class CompressFile implements Task {

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
        $this->compressor = $compressor;
        $this->sourcePath = $sourcePath;
        $this->shellProcessor = $shellProcessor;
    }

    /**
     * @throws \PhpDbCloud\ShellProcessing\ShellProcessFailed
     */
    public function execute() {
        return $this->shellProcessor->process($this->compressor->getCompressCommandLine($this->sourcePath));
    }
}
