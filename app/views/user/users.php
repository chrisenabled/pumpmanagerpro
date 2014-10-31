<?php
/* @var $this UserController */
/* @var $model User */
$this->breadcrumbs = array('Users');

$reader = Reader::sqlReaderId($model->id);
$personnel = Personnel::sqlPersonnelId($model->id);
$dynamic = UserDynamic::sqlDynamic($model->id);
    if($reader){
        $this->menu[] = array('label'=>'Delete Reader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('reader/delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'));}
    if($personnel){
        $this->menu[] = array('label'=>'Delete Personnel', 'url'=>'#', 'linkOptions'=>array('submit'=>array('personnel/delete','id'=>$model->id),
            'confirm'=>'Are you sure you want to delete this item?'));}
?>


<div>
<br><br>
<?php

    if($reader){
        echo 'Reader Details <br/><br/>&emsp;';
        echo 'Username : '.$reader['username'].'<br/>&emsp;';
        echo 'Date Created : '.$reader['date_created'] . '<br/>&emsp;';
        if(isset($dynamic['rlast_login'])){echo 'Last Logged in : '. $dynamic['rlast_login'];}
        else{echo 'Last Logged in : Never';}
    }

    if($personnel){
        if($reader){
            echo '<br/><br/><br/>';
            echo '<hr/>';
        }
        echo 'Personnel Details <br/><br/>&emsp;';
        echo 'Username : '.$personnel['username'].'<br/>&emsp;';
        echo 'Designation : '.$personnel['designation'].'<br/>&emsp;';
        echo 'Date Created : '.$personnel['date_created'] . '<br/>&emsp;';
        if(isset($dynamic['plast_login'])){
            echo 'Last Logged in : '. $dynamic['plast_login'];
        }
            else{
                echo 'Last Logged in : Never';
            }

    }
?>

</div><br><br>
    <div style="font-style: italic; text-align: right; color: #b8b6b1">
        Should a user forget password, simply delete the user's account and recreate it again from panel.
    </div>
