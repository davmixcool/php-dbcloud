<?php namespace PhpDbCloud\Tasks\Database;

use PhpDbCloud\Tasks\Task;
use PhpDbCloud\Databases\Database;
use PhpDbCloud\ShellProcessing\ShellProcessor;

/**
 * Class RestoreDatabase
 * @package PhpDbCloud\Tasks\Database
 */
class RestoreDatabase implements Task {

    /** @var string */
    private $inputPath;
    /** @var ShellProcessor */
    private $shellProcessor;
    /** @var Database */
    private $database;

    /**
     * @param Database $database
     * @param $inputPath
     * @param ShellProcessor $shellProcessor
     */
    public function __construct(Database $database, $inputPath, ShellProcessor $shellProcessor) {
        $this->inputPath = $inputPath;
        $this->shellProcessor = $shellProcessor;
        $this->database = $database;
    }

    /**
     * @throws \PhpDbCloud\ShellProcessing\ShellProcessFailed
     */
    public function execute() {
        return $this->shellProcessor->process($this->database->getRestoreCommandLine($this->inputPath));
    }
}
