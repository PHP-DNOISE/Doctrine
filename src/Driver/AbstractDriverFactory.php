<?php

namespace DNOISE\Component\Doctrine\Driver;



abstract class AbstractDriverFactory {

    public function __construct(){

        $this->file = dirname(debug_backtrace()[0]['file']). DIRECTORY_SEPARATOR .'config.' .$this->getFileExtension();
    }

    /**
     * @param mixed $file
     */
    public function setFile($file)
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }


    /**
     * Creates a configuration driver
     *
     * @param
     *
     * @return ConfigInterface
     */
    abstract public function createConnection();

    abstract public function getFileExtension();

}
