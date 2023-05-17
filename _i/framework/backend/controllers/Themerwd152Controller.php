<?php

//$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').'Funcfieldv2update1Controller.php');
$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/controllers/').'Rulev1Controller.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
$contentx = str_replace('Rulev1Controller', 'Rulev1xxxController', $contentx);
//$contentx = str_replace('update1', 'update2', $contentx);

eval($contentx);

class Themerwd152Controller extends Rulev1xxxController {
}

