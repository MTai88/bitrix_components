<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<?php
$APPLICATION->IncludeComponent(
    "mycompany:element.list",
    "",
    [
        'PAGE_SIZE' => 10,
    ]
);
?>
