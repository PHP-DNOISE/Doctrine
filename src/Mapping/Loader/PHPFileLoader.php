<?php

namespace DNOISE\Component\Doctrine\Mapping\Loader;

class PHPFileLoader extends FileLoader
{

    /**
     * An array config descriptions.
     *
     * @var array
     */
    protected $config = null;

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata($metadata)
    {
        if (null === $this->config) {

            if (!stream_is_local($this->file)) {
                throw new \InvalidArgumentException(sprintf('This is not a local file "%s".', $this->file));
            }

            if (!file_exists($this->file)) {
                throw new \InvalidArgumentException(sprintf('File "%s" not found.', $this->file));
            }

            $this->config = include $this->file;

            // empty file
            if (null === $this->config) {
                return false;
            }

            // not an array
            if (!is_array($this->config)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $this->file));
            }

        }

        return false;
    }
   
}