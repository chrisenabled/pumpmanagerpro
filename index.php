<?php

$yii=dirname(__FILE__).'/framework/yiilite.php';
$config=dirname(__FILE__).'/app/config/main.php';
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
error_reporting(0);
date_default_timezone_set('Africa/Lagos');
require_once($yii);
Yii::createWebApplication($config)->run();



