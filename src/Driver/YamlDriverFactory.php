<?php

namespace DNOISE\Component\Doctrine\Driver;

use DNOISE\Component\Doctrine\Driver\Yaml\Configuration;

class YamlDriverFactory extends AbstractDriverFactory {

    protected $file;


    public function getFileExtension(){
        return 'yml';
    }

    public function createConnection()
    {
        return new Configuration( $this->getFile() );
    }



}
