<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Добавить профиль");


$APPLICATION->IncludeComponent(
    'forms:profile.add',
    '',
    []
);

?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>