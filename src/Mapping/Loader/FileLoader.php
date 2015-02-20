<?php

namespace DNOISE\Component\Doctrine\Mapping\Loader;

abstract class FileLoader extends AbstractLoader
{
    protected $file;

    /**
     * Constructor.
     *
     * @param string $file The mapping file to load
     *
     * @throws \InvalidArgumentException if the mapping file does not exist
     * @throws \InvalidArgumentException if the mapping file is not readable
     */
    public function __construct($file)
    {
        if (!is_file($file)) {
            throw new \InvalidArgumentException(sprintf('The mapping file %s does not exist', $file));
        }
        if (!is_readable($file)) {
            throw new \InvalidArgumentException(sprintf('The mapping file %s is not readable', $file));
        }
        $this->file = $file;
    }
}