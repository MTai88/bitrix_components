<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
?><?php
$APPLICATION->IncludeComponent(
    "mycompany:element.list",
    "",
    [
        'PAGE_SIZE' => 10,
    ]
);
?>
<?php require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>
