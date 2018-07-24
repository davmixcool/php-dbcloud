<?php

namespace PhpDbCloud\Config;

/**
 * Class Config.
 */
class Config
{
    /** @var array */
    private $config = [];

    /**
     * @param $path
     *
     * @throws ConfigFileNotFound
     *
     * @return static
     */
    public static function fromPhpFile($path)
    {
        if (!file_exists($path)) {
            throw new ConfigFileNotFound('The configuration file "'.$path.'" could not be found.');
        }
        /* @noinspection PhpIncludeInspection */
        return new static(require $path);
    }

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @param $name
     * @param null $field
     *
     * @throws ConfigFieldNotFound
     * @throws ConfigNotFoundForConnection
     *
     * @return mixed
     */
    public function get($name, $field = null)
    {
        if (!array_key_exists($name, $this->config)) {
            throw new ConfigNotFoundForConnection("Could not find configuration for connection {$name}");
        }
        if ($field) {
            return $this->getConfigField($name, $field);
        }

        return $this->config[$name];
    }

    /**
     * @return array
     */
    public function getItems()
    {
        return $this->config;
    }

    /**
     * @param $name
     * @param $field
     *
     * @throws ConfigFieldNotFound
     *
     * @return mixed
     */
    private function getConfigField($name, $field)
    {
        if (!array_key_exists($field, $this->config[$name])) {
            throw new ConfigFieldNotFound("Could not find field {$field} in configuration for connection type {$name}");
        }

        return $this->config[$name][$field];
    }
}
