<?
define('NEWS_IBLOCK_ID',1);

AddEventHandler("iblock", "OnBeforeIBlockElementAdd", Array("MyClass", "OnBeforeIBlockElementAddHandler"));

class MyClass
{
    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
        if($arFields['IBLOCK_ID'] == NEWS_IBLOCK_ID){
            if(stripos($arFields['PREVIEW_TEXT'],'калейдоскоп') !== false){
                global $APPLICATION;
                $APPLICATION->throwException("Мы не используем слово калейдоскоп в анонсах");
                return false;
            }
        }
    }
}
?>