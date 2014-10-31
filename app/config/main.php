<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Pump Manager Pro',

    'runtimePath' => Yii::getPathOfAlias('application.runtime'),

	// preloading 'log' component
	'preload'=>array('log'),

    'aliases' => array(

        // yiistrap configuration
        'bootstrap' => realpath(__DIR__ . '/../extensions/bootstrap'), // change if necessary
        // yiiwheels configuration
        'yiiwheels' => realpath(__DIR__ . '/../extensions/yiiwheels'), // change if necessary
    ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'ext.YiiMailer.YiiMailer',
        'bootstrap.helpers.TbHtml',
        'bootstrap.behaviors.TbWidget',
        'application.extensions.giiplus.bootstrap.*'
  	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'pmp',
            'generatorPaths' => array(
                'ext.giiplus',
            ),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
        'marketer'=>array(
                'layoutPath'=>'app/modules/marketer/views/layouts'

        ),
        'admin'=>array(
                'layoutPath'=>'app/modules/admin/views/layouts',
                'preload'=>array('bootstrap'),
        ),

	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>false,
            'class'=>'CWebUser',
            //'autoUpdateFlash' => true, // add this line to disable the flash counter

		),

        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
        ),
        // yiiwheels configuration
        'yiiwheels' => array(
            'class' => 'yiiwheels.YiiWheels',
        ),

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
            ),
            'showScriptName'=>false,
            'urlSuffix'=> '.pmp'
		),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=pmp_dev',
			'emulatePrepare' => true,
            'username' => 'chrisenabled',
            'password' => 'chris123',
            'charset' => 'utf8',
            'schemaCachingDuration' => 3600*24*24,
            'enableProfiling'=>true,
            'enableParamLogging' => true,
        ),

        'session' => array(
             'class' => 'system.web.CDbHttpSession',
            'connectionID' => 'db',
            'autoCreateSessionTable'=>false,
            'sessionTableName' => 'pmp_session',
            'cookieMode' => 'only',
            'timeout' => 70000
        ),

        'cache' => array(
           'class' => 'CApcCache'
        ),


        'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CProfileLogRoute',
					//'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
    ),


	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'chrisenabled@gmail.com',

	),
);