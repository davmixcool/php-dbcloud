<?php

namespace PhpDbCloud\Databases;

/**
 * Class Database.
 */
interface Database
{
    /**
     * @param $type
     *
     * @return bool
     */
    public function handles($type);

    /**
     * @param array $config
     *
     * @return null
     */
    public function setConfig(array $config);

    /**
     * @param $inputPath
     *
     * @return string
     */
    public function getDumpCommandLine($inputPath);

    /**
     * @param $outputPath
     *
     * @return string
     */
    public function getRestoreCommandLine($outputPath);
}
