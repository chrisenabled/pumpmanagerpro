<?php

class AdminModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'admin.models.*',
			'admin.components.*',
		));
        $this->setComponents(array(
            'user' => array(
                'class' => 'CWebUser',
                'bootstrap'=>array(
                    'class'=>'ext.bootstrap.components.Bootstrap',
                ),
            )
        ));

        Yii::app()->user->setStateKeyPrefix('_admin');
        Yii::app()->homeUrl = 'index';
        Yii::app()->user->loginUrl = Yii::app()->createUrl("/{$this->id}/default/login");
        Yii::app()->errorHandler->errorAction='admin/default/error';
	}


	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
            $codeActions = array('subscribeCustomer');
            if( !in_array($action->id, $codeActions) && Yii::app()->user->hasState('isCode')){
                Yii::app()->user->isCode = false;
            }

            return true;
		}
		else
			return false;
	}
}
