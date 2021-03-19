<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<ul>
    <?foreach($arResult['DIFF_SECTIONS'] as $diffID):?>
    <li><b><?=$diffID['SECTION_NAME']?></b>
        <ul>
            <?foreach($diffID['PRODUCTS_ID'] as $prodID):?>
            <li>
                <?= $arResult['PRODUCTS'][$prodID]['NAME'] .' - '. $arResult['PRODUCTS'][$prodID]['PRICE'].' - '. $arResult['PRODUCTS'][$prodID]['MATERIAL'].' - '. $arResult['PRODUCTS'][$prodID]['ARTNUMBER']?>
            </li>
            <?endforeach;?>
        </ul>
    </li>
    <?endforeach;?>
</ul>