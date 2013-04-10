<?php

/**
 * DDoctrineConnectionFactory class file.
 * @author Jeferson Amorim <amorimjj@gmail.com>
 * @link https://github.com/amorimjj/yii-doctrine-orm-ext
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class DDoctrineConnectionParametersFactory {
    
    private static $_conn;
    
    protected static function getDriveName()
    {
        if ( ! self::$_conn )
            throw new ErrorException('Connection was not setted');
        
        return self::$_conn->driverName;
    }
    
    public static function getDataFromConnectionString($connectionString, $data)
    {
        $matches = array();
        preg_match("/$data=(?P<$data>[^;]*)/", $connectionString, $matches);
        return array_key_exists($data, $matches) ? $matches[$data] : false;
    }

    /**
     * @param CDbConnection $connection
     * @return array
     */
    public static function getConnectionParams(CDbConnection $connection)
    {
        self::$_conn = $connection;
        
        switch ($connection->driverName)
        {
            case 'mysql':
                return self::getMysqlConnectionParms($connection);
            case 'sqlite':
                return self::getSqliteConnectionParms($connection);
            default:
                throw new CDbException('DDocrine not implementend to ' . $connection->driverName);
        }
    }
    
    protected static function createMysqlConnectionSessionInit(\Doctrine\Common\EventManager $eventManager)
    {
        if ( self::$_conn->charset == 'utf8')
            $eventManager->addEventSubscriber(new \Doctrine\DBAL\Event\Listeners\MysqlSessionInit('utf8', 'utf8_unicode_ci'));   
    }

    public static function createConnectionSessionInit(\Doctrine\Common\EventManager $eventManager)
    {
        switch (self::getDriveName())
        {
            case 'mysql':
                self::createMysqlConnectionSessionInit($eventManager);
                break;
            case 'sqlite':
                break;
            default:
                throw new CDbException('DDocrine not implementend to ' . self::$_conn->driverName);
        }
    }
    
    protected static function getPortFromConnectionString($connectionString)
    {
        $port = self::getDataFromConnectionString($connectionString, 'port');
        return $port ? $port : 3306;;
    }


    /**
     * @param CDbConnection $connection
     * @return array
     */
    protected static function getMysqlConnectionParms(CDbConnection $connection)
    {
        $dbname = self::getDataFromConnectionString($connection->connectionString, 'dbname');
        $host = self::getDataFromConnectionString($connection->connectionString, 'host');
        $port = self::getPortFromConnectionString($connection->connectionString);
        
        return array(
                'dbname' => $dbname,
                'user' => $connection->username,
                'host' => $host,
                'password' => $connection->password,
                'port' => $port,
                'driver' => 'pdo_mysql'
        );
    }
    
    /**
     * @param CDbConnection $connection
     * @return array
     */
    protected static function getSqliteConnectionParms(CDbConnection $connection)
    {
        $path = str_replace('sqlite:', '', $connection->connectionString);
        
        return array(
                'path' => $path,
                'driver' => 'pdo_sqlite'
        );
    }
}

?>