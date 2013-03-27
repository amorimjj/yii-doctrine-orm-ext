<?php

/**
 * DDoctrinerContainer class file.
 * @author Jeferson Amorim <amorimjj@gmail.com>
 * @link https://github.com/amorimjj/yii-doctrine-orm-ext
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

Yii::import('ext.doctrineOrm.DDoctrineAutoload');
Yii::import('ext.doctrineOrm.DDoctrineConnectionParametersFactory');

class DDoctrineContainer extends CApplicationComponent {
    
    private static $_connectionId = 'db';

    private static $_dataMappingPath;
    
    private static $_mappingType;
    
    private static $_mappingTypes = array('annotation', 'xml', 'yaml');
    
    public function setConnectionId($connectionId)
    {
        self::$_connectionId = $connectionId;
    }

    public function setDataMappingPath($path)
    {
        self::$_dataMappingPath = YiiBase::getPathOfAlias($path);
    }
    
    public function setMappingType($type)
    {
        if ( array_search($type, self::$_mappingTypes) === false )
            throw new InvalidArgumentException('Mapping type should be annotation or xml or yaml');
        
        self::$_mappingType = $type;
    }
    
    protected function isDevMode()
    {
        return defined('YII_DEBUG');
    }
  
    protected function setDDoctrineAutoload()
    {
        spl_autoload_register('DDoctrineAutoload::load');
    }

    protected function getConfig()
    {
        if ( self::$_mappingType == 'xml')
            return Setup::createXMLMetadataConfiguration(array(self::$_dataMappingPath), $this->isDevMode());
        
        if ( self::$_mappingType == 'yaml')
            return Setup::createYAMLMetadataConfiguration(array(self::$_dataMappingPath), $this->isDevMode());
        
        return Setup::createAnnotationMetadataConfiguration(array(self::$_dataMappingPath), $this->isDevMode());
    }
    
    public function getEntityManager()
    {
        $conn = DDoctrineConnectionParametersFactory::getConnectionParams(Yii::app()->{self::$_connectionId});
        return EntityManager::create($conn, $this->getConfig());
    }
    
    public function init()
    {
        if ( ! $this->isInitialized )
            $this->setDDoctrineAutoload();
        
        parent::init();
    }
}

?>