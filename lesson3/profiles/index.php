<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Профили");


$APPLICATION->IncludeComponent(
    'rf:email.manager',
    'grid',
    []
);


?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>