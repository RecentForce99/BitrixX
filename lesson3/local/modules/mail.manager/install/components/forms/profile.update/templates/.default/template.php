<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}
?>
<table border="1">
    <tr>
        <?php
        foreach ($arResult['HEADER'] as $header) {
            ?>
            <td><?= $header ?></td>
            <?php
        }
        ?>
    </tr>

    <!--Если понадобится добавить ещё таблиц, то if можно заменить на switch-->

    <?php if($arResult['CLASS_NAME'] === 'Addresses'):?>

    <?php foreach ($arResult['PROFILES'] as $profile): ?>

            <tr>
                <td><?= $profile['ID'] ?></td>
                <td><?= $profile['COUNTRY'] ?></td>
                <td><?= $profile['ADDRESS'] ?></td>
                <td><?= $profile['PHONE_NUMBER'] ?></td>

            </tr>
        <?php endforeach;?>

            <?php elseif ($arResult['CLASS_NAME'] === 'Profile'): ?>
                <?php foreach ($arResult['PROFILES'] as $profile): ?>

            <tr>
                <td><?= $profile['ID'] ?></td>
                <td><?= $profile['NAME'] ?></td>
                <td><?= $profile['EMAIL'] ?></td>
                <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDRESSES_COUNTRY'] ?></td>
                <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDRESSES_ADDRESS'] ?></td>
                <td><?= $profile['MAIL_MANAGER_ORM_EMAILS_ADDRESSES_PHONE_NUMBER'] ?></td>

            </tr>
        <?php endforeach;?>
    <?php endif;?>


</table>
