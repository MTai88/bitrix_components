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
			'NAME' => GetMessage('MTH_TOP_COUNT'),
		),
        'NAME_TEMPLATE' => array(
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            'DEFAULT' => '',
            'PARENT' => 'BASE',
            'NAME' => GetMessage('MTH_NAME_TEMPLATE'),
        ),
        'DAYS_COUNT' => array(
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            'DEFAULT' => '30',
            'PARENT' => 'BASE',
            'NAME' => GetMessage('MTH_DAYS_COUNT'),
        ),
        'HLB' => array(
            'TYPE' => 'STRING',
            'MULTIPLE' => 'N',
            'PARENT' => 'BASE',
            'NAME' => GetMessage('MTH_HLB'),
        ),
		'CACHE_TIME' => array('DEFAULT' => 3600),
	),
);

?>