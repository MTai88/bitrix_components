<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>
<?php $APPLICATION->IncludeComponent(
    "mycompany:complex",
    "",
    Array(
        'SEF_MODE' => 'Y',
        'SEF_FOLDER' => '/complex/',
        'SEF_URL_TEMPLATES' => [],
        'VARIABLE_ALIASES' => []
    )
);?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>