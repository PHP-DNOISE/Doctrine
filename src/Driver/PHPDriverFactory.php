<?php

namespace DNOISE\Component\Doctrine\Driver;


use DNOISE\Component\Doctrine\Driver\PHP\Configuration;

class PHPDriverFactory extends AbstractDriverFactory {

    public function getFileExtension(){
        return 'php';
    }

    public function createConnection()
    {
        return new Configuration( $this->getFile() );
    }
}
