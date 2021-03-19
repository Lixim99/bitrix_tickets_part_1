<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
   $APPLICATION->SetPageProperty('head_style',(!empty($arResult['PIC_SRC']))?"background-image: url('" . $arResult['PIC_SRC'] . "'); background-size: contain;": '');
?>