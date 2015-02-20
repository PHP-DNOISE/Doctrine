<?php

namespace DNOISE\Component\Doctrine;

use DNOISE\Component\Doctrine\Mapping\Factory\ConfigurationMetadataFactory;
use DNOISE\Component\Doctrine\Mapping\Factory\MetadataFactoryInterface;
use DNOISE\Component\Doctrine\Mapping\Loader\PHPFileLoader;
use DNOISE\Component\Doctrine\Mapping\Loader\YamlFileLoader;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\EventManager;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

class DoctrineBuilder implements DoctrineBuilderInterface {


    protected $configurationLoader;

    protected $isDevMode;

    protected $metadataDirectory;

    protected $proxyDir;

    protected $proxyNamespace;

    /**
     * @var string
     */
    private $yamlMapping;

    /**
     * @var string
     */
    private $phpMapping;

    /**
     * @var MetadataFactoryInterface|null
     */
    private $metadataFactory;

    /** @var $configuration Configuration */
    protected $configuration;


    protected $eventManager;

    public static function create(){
        return new self();
    }

    public function __construct(){

        $this->proxyNamespace = 'PHPDNOISE\DoctrineProxy';
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


            if ( $this->proxyNamespace )
                $this->configuration->setProxyNamespace($this->proxyNamespace);

            if ( $this->proxyDir )
                $this->configuration->setProxyDir($this->proxyDir);

        }

        if (!$this->metadataFactory) {

            $loader = null;

            if ( $this->yamlMapping ) {
                $loader = new YamlFileLoader($this->yamlMapping);
            }elseif( $this->phpMapping ){
                $loader = new PHPFileLoader($this->phpMapping);
            }

            $this->metadataFactory = new ConfigurationMetadataFactory($loader);
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
     * @param string $proxyNamespace
     */
    public function setProxyNamespace($proxyNamespace)
    {
        $this->proxyNamespace = $proxyNamespace;
        return $this;
    }

    /**
     * @param mixed $proxyDir
     */
    public function setProxyDir($proxyDir)
    {
        $this->proxyDir = $proxyDir;
        return $this;
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


    /**
     * {@inheritdoc}
     */
    public function addYamlMapping($path)
    {
        $this->yamlMapping = $path;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addPhpMapping($path)
    {

        $this->phpMapping = $path;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setMetadataFactory(MetadataFactoryInterface $metadataFactory)
    {
        if ( $this->yamlMapping || $this->phpMapping ) {
            throw new \InvalidArgumentException('You cannot set a custom metadata factory after adding custom mappings. You should do either of both.');
        }
        $this->metadataFactory = $metadataFactory;
        return $this;
    }



}
