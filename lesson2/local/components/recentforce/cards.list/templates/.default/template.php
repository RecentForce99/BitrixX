<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Localization\Loc;

?>
<div class="list">
    <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
        <div>
            <p><?= Loc::getMessage('RF.CARD.LIST.NUMBER') ?> <?= $arItem['CARD_NUMBER'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.USER') ?> <?= $arItem['CARD_USER'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.TYPE') ?> <?= $arItem['CARD_TYPE'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.PRICE') ?> <?= $arItem['CARD_PRICE'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.TIME') ?> <?= $arItem['VALIDITY_TIME'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.END') ?> <?= $arItem['END_DATE'] ?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.SUM') ?> <?=  $arItem['CARD_PRICE'] * $arItem['VALIDITY_TIME']?></p>
            <p><?= Loc::getMessage('RF.CARD.LIST.SECRET') ?> <?= $arItem['CARD_SECRET'] ?></p>
        </div>
        <hr>
    <?php } ?>
</div>
