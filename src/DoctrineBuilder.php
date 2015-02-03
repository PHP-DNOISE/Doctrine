<?php

namespace DNOISE\Component\Doctrine;

use DNOISE\Component\Configuration\FactoryLoader;
use DNOISE\Component\Configuration\Loader;
use Doctrine\Common\EventManager;
use Doctrine\DBAL\Configuration;
use Doctrine\ORM\Tools\Setup;

class DoctrineBuilder {


    protected $configurationLoader;

    protected $isDevMode;

    protected $metadataDirectory;

    /** @var $configuration Configuration */
    protected $configuration;


    protected $eventManager;

    public static function create(){
        return new self();
    }

    public function __construct(){

        $this->configurationLoader = FactoryLoader::factory();
    }

    public function build(){

        if ( !$this->configuration){

            if ( !$this->metadataDirectory )
                if(  $directories = $this->configurationLoader->get('doctrine.annotation.paths', false) )
                    $this->setMetadataDirectory($directories);
                else
                    $this->setMetadataDirectory(__DIR__. DIRECTORY_SEPARATOR . 'Entity');

            $this->configuration = Setup::createAnnotationMetadataConfiguration($this->metadataDirectory, $this->isDevMode, null, null, false );
        }

        $this->connection =
            \Doctrine\DBAL\DriverManager::getConnection([
                'dbname' => $this->configurationLoader->get('doctrine.dbname'),
                'user' => $this->configurationLoader->get('doctrine.user'),
                'password' => $this->configurationLoader->get('doctrine.password'),
                'host' => $this->configurationLoader->get('doctrine.host'),
                'port' => $this->configurationLoader->get('doctrine.port'),
                'driver' => $this->configurationLoader->get('doctrine.driver'),
                'charset' => $this->configurationLoader->get('doctrine.charset'),
            ], $this->configuration, $this->eventManager ?: new EventManager() );

        return new Registry(
            $this->connection,
            $this->configuration
        );
    }

    /**
     * @param mixed $isDevMode
     */
    public function setIsDevMode($isDevMode)
    {
        $this->isDevMode = $isDevMode;
        return $this;
    }

    /**
     * @param mixed $metadataDirectory
     */
    public function setMetadataDirectory($metadataDirectory)
    {
        $this->metadataDirectory = is_array($metadataDirectory) ? $metadataDirectory : [$metadataDirectory];
        return $this;
    }

    /**
     * @param bool|\DNOISE\Component\Configuration\Loader $configurationLoader
     */
    public function setConfigurationLoader($configurationLoader)
    {
        $this->configurationLoader = $configurationLoader;
        return $this;
    }

    /**
     * @param \DNOISE\Component\Doctrine\Configuration $configuration
     */
    public function setConfiguration($configuration)
    {
        $this->configuration = $configuration;
        return $this;
    }

    /**
     * @param mixed $eventManager
     */
    public function setEventManager($eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }







}
