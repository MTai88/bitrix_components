<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
	'GROUPS' => array(),
	'PARAMETERS' => array(
        'VARIABLE_ALIASES' => Array(
            'ID' => Array(
                'NAME' => GetMessage('QS_ID_VAR'),
                'DEFAULT' => ''
            )
        ),
        'SEF_MODE' => Array(
            'list' => array(
                'NAME' => GetMessage('QS_PATH_TO_LIST'),
                'DEFAULT' => '',
                'VARIABLES' => array()
            ),
            'detail' => array(
                'NAME' => GetMessage('QS_PATH_TO_DETAIL'),
                'DEFAULT' => '#ID#/',
                'VARIABLES' => array('ID')
            )
        ),
    ),
);

?>