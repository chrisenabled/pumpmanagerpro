<?php
/* @var $this TankController */
/* @var $model Tank */

Yii::app()->clientScript->registerScript('viewProfile', "
$(document).ready(function() {
        ajaxProfile();
    });
");
?>

<?php echo $this->renderPartial('_viewprofile', array('model'=>$model)); ?>
<script type="text/javascript">
    <!--
    function ajaxProfile(){
        var myUrl = 'ajaxProfile';
        var myRand = parseInt(Math.random()* new Date().getTime());
        var modUrl = myUrl+"?rand="+myRand;
        $.ajax({
            url: modUrl,
            type: 'GET',
            dataType: 'HTML',
            cache: false,
            success: function(res){
                $('#profile').html(res);
            },
            error: function(jqXHR, textStatus, errorThrown){
                $('#profile').html('<strong style="color: #873514;"> Oops!!! There seems to be a glitch!</strong> '
                    + ': ' + textStatus + '  >>>>>>  ' + errorThrown );
            }
        });
    }
    -->
</script>
