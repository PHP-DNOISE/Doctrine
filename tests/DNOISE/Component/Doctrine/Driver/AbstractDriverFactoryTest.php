<?php

namespace DNOISE\Tests\Component\Doctrine\Driver;

use DNOISE\Component\Doctrine\Driver\AbstractDriverFactory;
use DNOISE\Component\Doctrine\Driver\ConfigurationLoaderDriverFactory;
use DNOISE\Component\Doctrine\Driver\PHPDriverFactory;
use DNOISE\Component\Doctrine\Driver\YamlDriverFactory;

/**
 * @covers DNOISE\Component\Component\Doctrine\Driver\AbstractDriverFactory
 */
class AbstractDriverFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function getDriverFactory()
    {
        return [
          //  [new ConfigurationLoaderDriverFactory()],
            [new PHPDriverFactory(__DIR__)],
            [new YamlDriverFactory()]
        ];
    }

    /**
     * @dataProvider getDriverFactory
     */
    public function testComponentCreation(AbstractDriverFactory $factory)
    {
        //$factory->setFile( __DIR__ . DIRECTORY_SEPARATOR. 'config.' . $factory->getFileExtension() );
        $config = $factory->createConnection();
        $this->assertInstanceOf('\DNOISE\Component\Doctrine\Driver\ConfigInterface', $config);

        $connection = $config->getConnection();
        $expected = [
            'dbname' => 'database',
            'user' => 'username',
            'password' => 'password',
            'host' => 'localhost',
            'port' => 3306,
            'driver' => 'pdo_mysql',
            'charset' => 'utf8'
        ];

        $this->assertEquals($expected, $connection);

    }
}
