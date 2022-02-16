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


    <?php switch ($arResult['CLASS_NAME']) { case 'Connection':?>
        <?php foreach ($arResult['PROFILES'] as $connect): ?>
            <tr>
                <td><?= $connect['ID'] ?></td>
                <td><?= $connect['NAME'] ?></td>
                <td><?= $connect['EMAIL'] ?></td>
                <td><?= $connect['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_COUNTRY'] ?></td>
                <td><?= $connect['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_ADDRESS'] ?></td>
                <td><?= $connect['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_PHONE_NUMBER'] ?></td>
            </tr>
        <?php endforeach; break;?>
    <?php case 'Addresses':?>
        <?php foreach ($arResult['PROFILES'] as $addresses): ?>
            <tr>
                <td><?= $addresses['ID'] ?></td>
                <td><?= $addresses['COUNTRY'] ?></td>
                <td><?= $addresses['ADDRESS'] ?></td>
                <td><?= $addresses['PHONE_NUMBER'] ?></td>
            </tr>
        <?php endforeach;break;?>
    <?php case 'Profile':?>
        <?php foreach ($arResult['PROFILES'] as $profile): ?>
            <tr>
                <td><?= $profile['ID'] ?></td>
                <td><?= $profile['NAME'] ?></td>
                <td style="min-width: 50px"><?= $profile['EMAIL'] ?></td>
            </tr>
        <?php endforeach;break;?>


    <?}?>
</table>
