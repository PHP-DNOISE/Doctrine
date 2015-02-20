<?php

namespace DNOISE\Component\Doctrine\Mapping\Loader;

interface LoaderInterface
{
    public function loadClassMetadata($metadata);
}