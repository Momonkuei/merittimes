<?php

//$contentx = file_get_contents(_BASEPATH.ds('/').target_app_name.ds('/controllers/').'Funcfieldv2update1Controller.php');
$contentx = file_get_contents(Yii::getPathOfAlias('system').ds('/').target_app_name.ds('/controllers/').'Funcfieldv2update1Controller.php');
$contentx = str_replace('<'.'?'.'php', '', $contentx);
$contentx = str_replace('Funcfieldv2update1Controller', 'Funcfieldv2xx1Controller', $contentx);
$contentx = str_replace('update1', 'update5', $contentx);

eval($contentx);

class Funcfieldv2update5Controller extends Funcfieldv2xx1Controller {
}

