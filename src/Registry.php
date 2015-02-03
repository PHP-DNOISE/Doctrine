<?php

namespace DNOISE\Component\Doctrine;

use DNOISE\Component\Configuration\Loader;
use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Driver\Connection;
use Doctrine\ORM\EntityManager;

class Registry {


    /** @var $configurationLoader \Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var $connection Connection */
    protected $connection;

    /** @var $configuration Configuration */
    protected $configuration;

    public function __construct(Connection $connection, Configuration $configuration){

        $this->connection = $connection;
        $this->configuration = $configuration;
    }

    public function getEntityManager(){

        if ( ! $this->entityManager ){
            $this->entityManager = EntityManager::create($this->connection, $this->configuration);
        }

        return $this->entityManager;
    }
}
