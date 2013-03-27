<?php

// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../framework.yii/yiit.php';

require_once($yiit);

Yii::setPathOfAlias('ext', dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR);
//require_once( Yii::getPathOfAlias('system.test.CTestCase').'.php' );
//require_once(dirname(__FILE__).'/WebTestCase.php');

//Yii::createWebApplication(array());
