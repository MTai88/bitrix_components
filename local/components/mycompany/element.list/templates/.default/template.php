<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
?>
<h2 class="title title--mb-large title--medium title-h2">Elements</h2>
<div class="container">
<?php foreach ($arResult['ITEMS'] as $item) { ?>
    <div class="b-toggle grid b-toggle--mt trs">

        <div class="b-toggle__head b-toggle__head--pointer b-toggle--questions aic">
            <div class="title title-h5"><?= $item["NAME"] ?></div>

            <span class="b-status b-status--question flex aic">
                <span><?= $item["STATUS"] ?></span>
            </span>
            <span class="text-right">
                <span class="text-gray text-gray--small text-right"><?= $item["DATE_CREATE"] ?></span>
            </span>
        </div>
    </div>
<?php } ?>

    <?php if (empty($arResult['ITEMS'])): ?>
        <div>No items added</div>
    <?php endif ?>

<?php
$APPLICATION->IncludeComponent(
    'bitrix:main.pagenavigation',
    '',
    [
        'NAV_OBJECT' => $arResult['NAV_OBJECT'],
        'SEF_MODE' => 'N',
        'AJAX_PARAMS' => [],
    ],
    false,
    ['HIDE_ICONS' => 'Y']
);
?>
</div>