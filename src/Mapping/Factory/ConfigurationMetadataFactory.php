<?php

namespace DNOISE\Component\Doctrine\Mapping\Factory;

use DNOISE\Component\Doctrine\Mapping\Loader\LoaderInterface;

class ConfigurationMetadataFactory implements MetadataFactoryInterface {

    protected $loader;

    public function __construct(LoaderInterface $loader = null)
    {
        $this->loader = $loader;
    }

}