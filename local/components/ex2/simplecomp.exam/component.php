<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if(!$productsIblockID = (int) $arParams['PRODUCT_IBLOCK_ID']) return false;
if(!$classifIblockID = (int) $arParams['CLASSIF_IBLOCK_ID']) return false;
if(!$classifCode = trim($arParams['CLASSIF_CODE'])) return false;

if ($this->StartResultCache())
{
    //PRODUCTS
    $arProducts = array();
    $arDiffSect = array();
    $arSelect = Array("ID", 'IBLOCK_ID', 'NAME');
    $arFilter = Array("IBLOCK_ID"=>$productsIblockID, "ACTIVE"=>"Y", '!PROPERTY_' . $classifCode => false);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>20), $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arFields['PROPERTIES'] = $ob->GetProperties();
       
        $arProducts[$arFields['ID']] = array(
           'NAME' =>  $arFields['NAME'],
           'PRICE' =>  $arFields['PROPERTIES']['PRICE']['VALUE'],
           'MATERIAL' =>  $arFields['PROPERTIES']['MATERIAL']['VALUE'],
           'ARTNUMBER' =>  $arFields['PROPERTIES']['ARTNUMBER']['VALUE'],
           $classifCode =>  $arFields['PROPERTIES'][$classifCode]['VALUE'],
        );

        $arDiffSect = array_merge($arDiffSect,$arFields['PROPERTIES'][$classifCode]['VALUE']);
    }
    
    
    //DIFF SECTIONS
    $arDiffSections = array();
    $arFilter = array('IBLOCK_ID' => $classifIblockID, 'ID' => array_unique($arDiffSect));
    $db_list = CIBlockSection::GetList(Array($by=>$order), $arFilter, true, array('ID', 'NAME'));
    while ($arSect = $db_list->GetNext())
    {
         foreach($arProducts as $prodID => $prodVal){
             if(in_array($arSect['ID'], $prodVal[$classifCode])){
                if(!isset($arDiffSections[$arSect['ID']])){
                 $arDiffSections[$arSect['ID']] = array(
                    'SECTION_NAME' => $arSect['NAME'],
                    'PRODUCTS_ID' => array($prodID),
                 );
                }else{
                    $arDiffSections[$arSect['ID']]['PRODUCTS_ID'][] = $prodID;
                }
             }
         }
    }
    
    $arResult['DIFF_SECTIONS'] = $arDiffSections;
    $arResult['PRODUCTS'] = $arProducts;
    $arResult['COUNT_PRODUCTS'] = count($arProducts);
    
    $this->setResultCacheKeys(array('COUNT_PRODUCTS'));
    
    $this->IncludeComponentTemplate();
}

$APPLICATION->SetPageProperty('title', 'Элементов - ' . $arResult["COUNT_PRODUCTS"]); 
?>