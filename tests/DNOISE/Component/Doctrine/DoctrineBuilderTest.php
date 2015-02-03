<?php

namespace DNOISE\Tests\Component\Doctrine;
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

        $loader = $this->getMockBuilder('DNOISE\Component\Configuration\Loader')
            ->setMethods(['get'])
            ->disableOriginalConstructor()
            ->getMock()
        ;

        $loader->expects($this->exactly(7))
                ->method('get')
                ->will($this->onConsecutiveCalls('foo', 'bar', 'foo', 'bar', 'foo', 'pdo_mysql', 'foo'))
        ;

        $this->builder = DoctrineBuilder::create()
                   ->setConfigurationLoader($loader)
        ;

        $this->doctrine = $this->builder->build();

        $this->entityManager = $this->doctrine->getEntityManager();
    }

    public function testLoadDefault(){

        $this->assertInstanceOf('DNOISE\Component\Doctrine\Registry', $this->doctrine);
        $this->assertInstanceOf('\Doctrine\ORM\EntityManager', $this->entityManager);


        $this->assertSame(
            $this->getField($this->doctrine, 'configuration'),
            $this->getField($this->builder, 'configuration')
        );

        $this->assertSame(
            $this->getField($this->doctrine, 'connection'),
            $this->getField($this->builder, 'connection')
        );

    }

    public function testBuildCustomModeAndMetadataDirectory(){

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

    private function getField($obj, $name) {
        $ref = new \ReflectionProperty($obj, $name);
        $ref->setAccessible(true);
        return $ref->getValue($obj);
    }




}