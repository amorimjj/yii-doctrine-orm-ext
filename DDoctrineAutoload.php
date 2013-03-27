<?php
/**
 * DDoctrineAutoload class file.
 * @author Jeferson Amorim <amorimjj@gmail.com>
 * @link https://github.com/amorimjj/yii-doctrine-orm-ext
 * @copyright Copyright &copy; 2008-2011 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
class DDoctrineAutoload
{
    public static function load($class_name) {
        
        $file = $class_name . '.php';

	if ( file_exists($doctrineFile = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'DoctrineORM' . DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR . $file) )
		require_once $doctrineFile;
    }
}

?>
