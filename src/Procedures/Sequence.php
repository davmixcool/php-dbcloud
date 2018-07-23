<?php namespace PhpDbCloud\Procedures;

use PhpDbCloud\Tasks\Task;

/**
 * Class Sequence
 * @package PhpDbCloud\Procedures
 */
class Sequence {

    /** @var array|Task[] */
    private $tasks = [];

    /**
     * @param \PhpDbCloud\Tasks\Task $task
     */
    public function add(Task $task) {
        $this->tasks[] = $task;
    }

    /**
     * Run the procedure.
     * @return void
     */
    public function execute() {
        foreach ($this->tasks as $task) {
            $task->execute();
        }
    }
}
