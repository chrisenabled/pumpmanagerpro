<?php

    echo '<div style="width: 600px;">';
        $this->widget('zii.widgets.jui.CJuiAccordion', array(
            'panels'=>array(
                'Change username'=>$this->renderPartial('_username', array('model'=>$model),true),
                'Change Password'=>$this->renderPartial('_password', array('model'=>$model),true),
                'Change Address'=>$this->renderPartial('_address', array('model'=>$model),true),
                'Change Contacts'=>$this->renderPartial('_contact', array('model'=>$model),true),
                'Change Security Question'=>$this->renderPartial('_question',
                    array('model'=>UserStatic::model()->findByAttributes(array('user_id'=>$model->id)),'user'=>$model),true),
            ),
            // additional javascript options for the accordion plugin
            'options'=>array(
                //'heightStyle'=> 'content',
                //'collapsible'=>true,
                //'active'=>false
            ),

        ));
    echo '</div>';
