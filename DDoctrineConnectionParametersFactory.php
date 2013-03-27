<?php

/**
 * DDoctrineConnectionFactory class file.
 * @author Jeferson Amorim <amorimjj@gmail.com>
 * @link https://github.com/amorimjj/yii-doctrine-orm-ext
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class DDoctrineConnectionParametersFactory {
    
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
        switch ($connection->driverName)
        {
            case 'mysql':
                return self::getMysqlConnectionParms($connection);
            default:
                throw new CDbException('DDocrine not implementend to ' . $connection->driverName);
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
}

?>