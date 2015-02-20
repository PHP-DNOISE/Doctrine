<?php

namespace DNOISE\Component\Doctrine;

interface DoctrineBuilderInterface {


    /**
     * Builds and returns a new Registry object.
     *
     * @return RegistryInterface The built validator.
     */
    public function build();

    /**
     * @param string $proxyNamespace
     */
    public function setProxyNamespace($proxyNamespace);


    public function setProxyDir($proxyDir);


    /**
     * @param mixed $isDevMode
     */
    public function setIsDevMode($isDevMode);

    /**
     * @param mixed $metadataDirectory
     */
    public function setMetadataDirectory($metadataDirectory);

    /**
     * @param bool|\DNOISE\Component\Configuration\Loader $configurationLoader
     */
    public function setConfigurationLoader($configurationLoader);

    /**
     * @param \DNOISE\Component\Doctrine\Configuration $configuration
     */
    public function setConfiguration($configuration);
    /**
     * @param mixed $eventManager
     */
    public function setEventManager($eventManager);

    public function addYamlMapping($path);

    public function addPhpMapping($path);







}
