<?php

namespace DNOISE\Component\Doctrine\Driver\Yaml;

use DNOISE\Component\Doctrine\Driver\Configuration as BaseConfiguration;
use Symfony\Component\Yaml\Yaml;

class Configuration extends BaseConfiguration {


    public function getConnection(){

        return  Yaml::parse( file_get_contents( $this->file ) );

    }

}