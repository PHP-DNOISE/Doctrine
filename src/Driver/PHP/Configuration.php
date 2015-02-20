<?php

namespace DNOISE\Component\Doctrine\Driver\PHP;

use DNOISE\Component\Doctrine\Driver\Configuration as BaseConfiguration;

class Configuration extends BaseConfiguration {

    public function getConnection(){

        return include $this->file;

    }

}