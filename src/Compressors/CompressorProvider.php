<?php

namespace PhpDbCloud\Compressors;

/**
 * Class CompressorProvider.
 */
class CompressorProvider
{
    /** @var array|Compressor[] */
    private $compressors = [];

    /**
     * @param Compressor $compressor
     */
    public function add(Compressor $compressor)
    {
        $this->compressors[] = $compressor;
    }

    /**
     * @param $name
     *
     * @throws CompressorTypeNotSupported
     *
     * @return Compressor
     */
    public function get($name)
    {
        foreach ($this->compressors as $compressor) {
            if ($compressor->handles($name)) {
                return $compressor;
            }
        }

        throw new CompressorTypeNotSupported("The requested compressor type {$name} is not currently supported.");
    }
}
