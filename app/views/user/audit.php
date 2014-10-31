<h2>Audit</h2>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
    'tabs' => array(
        array('label' => 'Periodic', 'content' => $this->renderPartial('_audit', array('model'=>Yii::app()->user->model),true), 'active' => true),
        array('label' => 'Custom', 'content' => $this->renderPartial('_customAudit', array('model'=>Yii::app()->user->model),true),),
        array('label' => 'Messages', 'items' => array(
            array('label' => '@fat', 'content' => '...'),
            array('label' => '@mdo', 'content' => '...'),
        )),
    ),
)); ?>

<?php
function getisp($ip='') {
    if ($ip=='') $ip = $_SERVER['REMOTE_ADDR'];
    $longisp = @gethostbyaddr($ip);
    $isp = explode('.', $longisp);
    $isp = array_reverse($isp);
    $tmp = $isp[1];
    if (preg_match("/\<(org?|com?|net)\>/i", $tmp)) {
        $myisp = $isp[2].'.'.$isp[1].'.'.$isp[0];
    } else {
        $myisp = $isp[1].'.'.$isp[0];
    }
    if (preg_match("/[0-9]{1,3}\.[0-9]{1,3}/", $myisp))
        return 'ISP lookup failed.';
    return $myisp;
}
echo getisp();
?>