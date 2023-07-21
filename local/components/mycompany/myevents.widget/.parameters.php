<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = array(
	'GROUPS' => array(),
	'PARAMETERS' => array(
		'COUNT' => array(
			'TYPE' => 'STRING',
			'MULTIPLE' => 'N',
			'DEFAULT' => '3',
			'PARENT' => 'BASE',
			'NAME' => GetMessage('EVENT_WIDGET_COUNT'),
		),
		'CACHE_TIME' => array('DEFAULT' => 3600),
	),
);

?>