<?php

namespace DNOISE\Component\Doctrine\Driver;



abstract class Configuration implements ConfigInterface {

    /**
     * @var string
     */
    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file){

        $this->file = (string) $file;

    }

}
