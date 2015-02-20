<?php

namespace DNOISE\Component\Doctrine\Mapping\Loader;

use Symfony\Component\Yaml\Yaml;

class YamlFileLoader extends FileLoader
{
    private $yamlParser;

    /**
     * An array of YAML config descriptions.
     *
     * @var array
     */
    protected $config = null;

    /**
     * {@inheritdoc}
     */
    public function loadClassMetadata($metadata)
    {
        if (null === $this->config) {

            if (!stream_is_local($this->file)) {
                throw new \InvalidArgumentException(sprintf('This is not a local file "%s".', $this->file));
            }

            if (!file_exists($this->file)) {
                throw new \InvalidArgumentException(sprintf('File "%s" not found.', $this->file));
            }

            if (null === $this->yamlParser) {
                $this->yamlParser = new Yaml();
            }

            $this->config = $this->yamlParser->parse(file_get_contents($this->file));

            // empty file
            if (null === $this->config) {
                return false;
            }

            // not an array
            if (!is_array($this->config)) {
                throw new \InvalidArgumentException(sprintf('The file "%s" must contain a YAML array.', $this->file));
            }

            /*if (isset($this->classes['namespaces'])) {
                foreach ($this->classes['namespaces'] as $alias => $namespace) {
                    $this->addNamespaceAlias($alias, $namespace);
                }
                unset($this->classes['namespaces']);
            }*/
        }

        return false;
    }

}