<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карты");
?>

<?php

    $APPLICATION->IncludeComponent(
	"recentforce:cards.list",
	"grid", 
	array(
		"COMPONENT_TEMPLATE" => "grid"
	),
	false
);
?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>