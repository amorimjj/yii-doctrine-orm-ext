<?php

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.0 on 2013-03-27 at 16:36:16.
 */

Yii::import('ext.doctrineOrm.DDoctrineConnectionParametersFactory');

class DDoctrineConnectionParametersFactoryTest extends PHPUnit_Framework_TestCase {

    
    public function connecionStringDataProvider()
    {
        return array (
            array('mysql:host=localhost;dbname=testDataBase','host','localhost'),
            array('mysql:host=localhost;dbname=testDataBase','dbname','testDataBase'),
            array('mysql:host=localhost;dbname=testDataBase;port=1000','port','1000'),
        );
    }
    
    /**
     * @covers DDoctrineConnectionParametersFactory::getDataFromConnectionString
     * @dataProvider connecionStringDataProvider
     * @param type $conectionString
     * @param type $data
     * @param type $expected
     */
    public function testGetConnectionParams_WhenReceiveTryRetrieveDbNameFromConnectionString_ShouldReturnDbName($conectionString, $data, $expected)
    {
        $this->assertEquals($expected, DDoctrineConnectionParametersFactory::getDataFromConnectionString($conectionString, $data));
    }
    

    /**
     * @covers DDoctrineConnectionParametersFactory::getConnectionParams
     */
    public function testGetDataFromConnectionString_WhenReceiveAMysqlConnection_ShouldReturnMysqlDataConnection()
    {
        $dataMock = array(
                'dbname' => 'fake',
                'user' => 'maroto',
                'host' => '8.8.8.8',
                'password' => 'secret',
                'port' => '3306',
                'driver' => 'pdo_mysql'
        );
        
        $connectionStub = new CDbConnection('mysql:host=8.8.8.8;dbname=fake', 'maroto', 'secret');
        
        $this->assertEquals($dataMock, DDoctrineConnectionParametersFactory::getConnectionParams($connectionStub));
    }
    
    /**
     * @covers DDoctrineConnectionParametersFactory::getConnectionParams
     */
    public function testGetDataFromConnectionString_WhenReceiveAMysqlConnectionWithPort_ShouldReturnMysqlDataConnectionWithGivenPort()
    {
        $dataMock = array(
                'dbname' => 'fake',
                'user' => 'maroto',
                'host' => '8.8.8.8',
                'password' => 'secret',
                'port' => '5000',
                'driver' => 'pdo_mysql'
        );
        
        $connectionStub = new CDbConnection('mysql:host=8.8.8.8;port=5000;dbname=fake', 'maroto', 'secret');
        
        $this->assertEquals($dataMock, DDoctrineConnectionParametersFactory::getConnectionParams($connectionStub));
    }
    
    /**
     * @covers DDoctrineConnectionParametersFactory::getConnectionParams
     */
    public function testGetDataFromConnectionString_WhenReceiveNotEqualsMysql_ShouldThrowException()
    {
        $this->setExpectedException('CDbException');
        $connectionStub = new CDbConnection('sqlite:/path/data.sql');
        DDoctrineConnectionParametersFactory::getConnectionParams($connectionStub);
    }

}
