<?php

namespace DNOISE\Tests\Component\Doctrine;
use DNOISE\Component\Doctrine\Config\LoaderInterface;
use DNOISE\Component\Doctrine\DoctrineBuilder;
use DNOISE\Component\Doctrine\Registry;


/**
 * @covers DNOISE\Component\Component\Doctrine\DoctrineBuilder
 */
class DoctrineBuilderTest extends \PHPUnit_Framework_TestCase
{

    /** @var $builder DoctrineBuilder */
    private $builder;

    /** @var $doctrine Registry */
    private $doctrine;

    private $entityManager;

    public function setUp(){

/*        $loader = $this->getMockConfigurationLoader();

        $this->assertLoaderInterface($loader);

        $this->builder = DoctrineBuilder::create()
                   ->setConfigurationLoader($loader)
        ;

        $this->doctrine = $this->builder->build();

        $this->entityManager = $this->doctrine->getEntityManager();*/
    }


    private function assertLoaderInterface(LoaderInterface $loader){

       /* $loader->expects($this->once())
            ->method('getMetadataDirectories')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getDatabaseName')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getUsername')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getPassword')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getHost')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getPort')
            ->will($this->returnValue(false))
        ;

        $loader->expects($this->once())
            ->method('getDriver')
            ->will($this->returnValue('pdo_mysql'))
        ;

        $loader->expects($this->once())
            ->method('getCharset')
            ->will($this->returnValue(false))
        ;*/

    }

    public function testLoadDefault(){

        $builder = DoctrineBuilder::create();
        $doctrine = $builder->build();

        $this->assertInstanceOf('DNOISE\Component\Doctrine\Registry', $doctrine);


        $this->assertSame(
            $this->getField($doctrine, 'configuration'),
            $this->getField($builder, 'configuration')
        );

        $this->assertSame(
            $this->getField($doctrine, 'connection'),
            $this->getField($builder, 'connection')
        );

        $entityManager = $doctrine->getEntityManager();
        $this->assertInstanceOf('\Doctrine\ORM\EntityManager', $entityManager);
    }

/*    public function testBuildCustomModeAndMetadataDirectory(){

        $directory = sys_get_temp_dir();

        $builder = DoctrineBuilder::create()
                   ->setIsDevMode(true)
                   ->setMetadataDirectory($directory)
        ;

        $doctrine = $builder->build();

        $isDevMode = $this->getField($builder, 'isDevMode');
        $metadataDirectory = $this->getField($builder, 'metadataDirectory');

        $this->assertEquals($metadataDirectory, [$directory]);
        $this->assertTrue($isDevMode);

    }

    public function testBuildMetadataDirectoryFromConfig(){

        $directory = [sys_get_temp_dir()];

        $loader = $this->getMockConfigurationLoader();

        $loader->expects($this->exactly(8))
            ->method('get')
            ->will($this->onConsecutiveCalls($directory, 'foo', 'bar', 'foo', 'bar', 'foo', 'pdo_mysql', 'foo'))
        ;

        $builder = DoctrineBuilder::create()
            ->setConfigurationLoader($loader)
        ;

        $doctrine = $builder->build();
        $this->assertEquals($this->getField($builder, 'metadataDirectory'), $directory);

    }*/

    protected function getMockConfigurationLoader(){

        return $this->getMockBuilder('DNOISE\Component\Component\Doctrine\Config\ConfigurationLoader')
            ->setMethods(['getMetadataDirectories', 'getDatabaseName', 'getUsername', 'getPassword', 'getHost','getPort', 'getDriver', 'getCharset'])
            ->disableOriginalConstructor()
            ->getMock()
            ;

    }

    protected function getMockArrayLoader(){

        return $this->getMockBuilder('DNOISE\Component\Component\Doctrine\Config\ArrayLoader')
            ->setMethods(['getMetadataDirectories', 'getDatabaseName', 'getUsername', 'getPassword', 'getHost','getPort', 'getDriver', 'getCharset'])
            ->disableOriginalConstructor()
            ->getMock()
            ;

    }

    public function getMockFactories()
    {
        return array(
            [$this->getMockConfigurationLoader()],
            [$this->getMockArrayLoader()],
        );
    }

    private function getField($obj, $name) {
        $ref = new \ReflectionProperty($obj, $name);
        $ref->setAccessible(true);
        return $ref->getValue($obj);
    }




}