<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?><?php
$APPLICATION->IncludeComponent(
    "mycompany:myevents.widget",
    "",
    [
        "COUNT" => 5
    ]
);
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
