<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?>
<?php $APPLICATION->IncludeComponent(
    "mycompany:user_actions_count.widget",
    "",
    [
        'HLB' => 'Actions', // Higload-block name
        'DAYS_COUNT' => 30,
        'COUNT' => 5, // count of element displaying
        'CACHE_TIME' => 3600
    ]
);?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>