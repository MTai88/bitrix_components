<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Web\Uri;
use Bitrix\Main\Grid\Declension;

$this->SetViewTarget('sidebar');

$actionDeclension = new Declension(
    Loc::getMessage('MTH_ACTION_ONE'),
    Loc::getMessage('MTH_ACTION_FOUR'),
    Loc::getMessage('MTH_ACTION_FIVE')
);
?>
<div class="sidebar-widget sidebar-widget-top-actions">
    <div class="sidebar-widget-top">
        <div class="sidebar-widget-top-title">
            <?= Loc::getMessage('MTH_TOP_TITLE', [
                '#COUNT#' => $arParams["COUNT"]
            ]) ?>
        </div>
    </div>
    <div class="sidebar-widget-content">
        <?php
        foreach ($arResult['COUNTS'] as $userId => $count):
            $user = $arResult['USERS'][$userId];
            $avatarStyle = (isset($user['PERSONAL_PHOTO']['src']) ? "background: url('" . Uri::urnEncode($user['PERSONAL_PHOTO']['src']) . "') no-repeat center; background-size: cover;" : '');
            ?>
            <a href="<?= $user['DETAIL_URL'] ?>" class="sidebar-widget-item --row">
                <span class="user-avatar user-default-avatar"
                      style="<?= $avatarStyle ?>"></span>
                <span class="sidebar-user-info">
                    <span class="user-birth-name"><?= CUser::FormatName($arParams['NAME_TEMPLATE'], $user, true); ?></span>
                    <span class="user-birth-date"><?=$count?> <?= $actionDeclension->get($count) ?></span>
                </span>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
$this->EndViewTarget();