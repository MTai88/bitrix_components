<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

Extension::load('ui.bootstrap4');
?>
<h3><?= Loc::getMessage('EVENT_WIDGET_TITLE') ?></h3>

<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-events-all-tab" data-toggle="tab" href="#nav-events-all" role="tab" aria-controls="nav-events-all" aria-selected="true">
            <?= Loc::getMessage('EVENT_WIDGET_ALL') ?>
        </a>
        <a class="nav-item nav-link" id="nav-events-my-tab" data-toggle="tab" href="#nav-events-my" role="tab" aria-controls="nav-events-my" aria-selected="false">
            <?= Loc::getMessage('EVENT_WIDGET_MY') ?>
        </a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-events-all" role="tabpanel" aria-labelledby="nav-events-all-tab">
        <?php foreach ($arResult['EVENTS'] as $item): ?>
            <a href="<?= $item["DETAIL_PAGE_URL"] ?>" class="card mb-4">
                <?php if (!empty($item["PREVIEW_PICTURE"])) { ?>
                    <img class="card-img-top" src="<?= $item["PREVIEW_PICTURE"]["src"] ?>" alt="Img">
                <?php } ?>

                <div class="card-body">
                    <h5 class="card-title"><?= $item["NAME"] ?></h5>
                    <p class="card-text"><small><?= $item["DATE"] ?></small></p>
                </div>
            </a>
        <?php endforeach; ?>
        <?php if(empty($arResult['EVENTS'])){?>
            <p><?= Loc::getMessage('EVENT_EMPTY_RESULT') ?></p>
        <?php }?>
    </div>
    <div class="tab-pane fade" id="nav-events-my" role="tabpanel" aria-labelledby="nav-events-my-tab">
        <?php foreach ($arResult['MY_EVENTS'] as $item): ?>
            <a href="<?= $item["DETAIL_PAGE_URL"] ?>" class="card mb-4">
                <?php if (!empty($item["PREVIEW_PICTURE"])) { ?>
                    <img class="card-img-top" src="<?= $item["PREVIEW_PICTURE"]["src"] ?>" alt="Img">
                <?php } ?>

                <div class="card-body">
                    <h5 class="card-title"><?= $item["NAME"] ?></h5>
                    <p class="card-text"><small><?= $item["DATE"] ?></small></p>
                </div>
            </a>
        <?php endforeach; ?>
        <?php if(empty($arResult['MY_EVENTS'])){?>
            <p><?= Loc::getMessage('EVENT_EMPTY_RESULT') ?></p>
        <?php }?>
    </div>
</div>