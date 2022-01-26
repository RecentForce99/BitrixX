<?php

namespace RF\Components;

use Bitrix\Iblock\IblockTable;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\Grid\Options as GridOptions;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Loader;
use \Bitrix\Main\UI\PageNavigation;
use \CBitrixComponent;
use \CIBlockElement;
use \Exception;
use \Bitrix\Main\UI\Filter\Options;

/**
 * Class CardsListComponent
 * @package YLab\Components
 * Компонент отображения списка элементов нашего ИБ
 */
class CardsListComponent extends CBitrixComponent
{
    /** @var int $idIBlock ID информационного блока */
    private $idIBlock;

    /** @var string $templateName Имя шаблона компонента */
    private $templateName;

    /**
     * @param $arParams
     * @return array
     * @throws \Bitrix\Main\LoaderException
     */
    public function onPrepareComponentParams($arParams)
    {
        Loader::includeModule('iblock');

        $this->templateName = $this->GetTemplateName();


        return $arParams;
    }

    /**
     * Метод executeComponent
     *
     * @return mixed|void
     * @throws Exception
     */
    public function executeComponent()
    {

        $this->idIBlock = self::getIBlockIdByCode('credit_card');

        if ($this->templateName == 'grid') {
            $this->showByGrid();
        } else {
            $this->arResult['ITEMS'] = $this->getElements();
        }


        $this->includeComponentTemplate();
    }

    /**
     * Получим элементы ИБ
     * @return array
     */
    public function getElements(): array
    {
        $result = [];

        $arFilter = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $this->idIBlock,
        ];

        $elements = CIBlockElement::GetList(
            [],
            $arFilter,
            false,
            false,
            [
                'ID',
                'IBLOCK_ID',
                'PROPERTY_CARD_NUMBER',
                'PROPERTY_CARD_USER',
                'PROPERTY_CARD_TYPE',
                'PROPERTY_CARD_PRICE',
                'PROPERTY_CARD_PRICE_SUM',
                'PROPERTY_VALIDITY_TIME',
                'PROPERTY_END_DATE',
            ]
        );


        while ($element = $elements->GetNext()) {
            $cardSecret = md5($element['PROPERTY_CARD_NUMBER_VALUE']);
            $result[] = [
                'ID' => $element['ID'],
                'CARD_NUMBER' => $element['PROPERTY_CARD_NUMBER_VALUE'],
                'CARD_USER' => $element['PROPERTY_CARD_USER_VALUE'],
                'CARD_TYPE' => $element['PROPERTY_CARD_TYPE_VALUE'],
                'CARD_PRICE' => $element['PROPERTY_CARD_PRICE_VALUE'],
                'VALIDITY_TIME' => $element['PROPERTY_VALIDITY_TIME_VALUE'],
                'END_DATE' => $element['PROPERTY_END_DATE_VALUE'],
                'CARD_SECRET' => $cardSecret,
            ];
        }

        return $result;
    }

    /**
     * Отображение через грид
     */
    public function showByGrid()
    {
        $this->arResult['GRID_ID'] = $this->getGridId();

        $this->arResult['GRID_BODY'] = $this->getGridBody();
        $this->arResult['GRID_HEAD'] = $this->getGridHead();

        $this->arResult['GRID_NAV'] = $this->getGridNav();

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('RF.CARD.LIST.CLASS.ADD');
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */

    private function getGridBody(): array
    {
        $arBody = [];

        $arItems = $this->getElements();

        foreach ($arItems as $arItem) {

            $arGridElement = [
                'data' => [
                    'ID' => $arItem['ID'],
                    'CARD_NUMBER' => $arItem['CARD_NUMBER'],
                    'CARD_USER' => $arItem['CARD_USER'],
                    'CARD_TYPE' => $arItem['CARD_TYPE'],
                    'CARD_PRICE' => $arItem['CARD_PRICE'],
                    'CARD_PRICE_SUM' => $arItem['CARD_PRICE'] * $arItem['VALIDITY_TIME'],
                    'VALIDITY_TIME' => $arItem['VALIDITY_TIME'],
                    'END_DATE' => $arItem['END_DATE'],
                    'CARD_SECRET' => $arItem['CARD_SECRET'],
                ],
                'actions' => [
                    [
                        'text'    => 'Редактировать',
                        'onclick' => 'document.location.href="/edit/"'
                    ],
                    [
                        'text'    => 'Удалить',
                        'onclick' => 'document.location.href="/delete/"'
                    ]

                ],


            ];

            $arBody[] = $arGridElement;
        }
        return $arBody;

    }

    /**
     * Возвращает идентификатор грида.
     *
     * @return string
     */
    private function getGridId(): string
    {
        return 'recentforce_cards_list_' . $this->idIBlock;
    }

    /**
     * Возращает заголовки таблицы.
     *
     * @return array
     */
    private function getGridHead(): array
    {
         $arr = [
            [
                'id' => 'ID',
                'name' => 'ID',
                'default' => true,
                'sort' => 'ID',
                'type' => 'number',

            ],
            [
                'id' => 'CARD_NUMBER',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.NUMBER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_NUMBER',
                'type' => 'number',

            ],
            [
                'id' => 'CARD_USER',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.USER'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_USER',
                'type' => 'string',

            ],
            [
                'id' => 'CARD_TYPE',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.TYPE'),
                'default' => true,
                'sort' => 'PROPERTY_CARD_TYPE',
                'type' => 'list', 'items' => ['Любой', 'Личная', 'Корпоративная']

            ],
             [
                 'id' => 'CARD_PRICE',
                 'name' => Loc::getMessage('RF.CARD.LIST.CLASS.PRICE'),
                 'default' => true,
                 'sort' => 'PROPERTY_CARD_PRICE',
                 'type' => 'number',

             ],
             [
                 'id' => 'CARD_PRICE_SUM',
                 'name' => Loc::getMessage('RF.CARD.LIST.CLASS.SUM'),
                 'default' => true,
                 'sort' => 'PROPERTY_CARD_PRICE_SUM',
                 'type' => 'number',

             ],
            [
                'id' => 'VALIDITY_TIME',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.TIME'),
                'default' => true,
                'sort' => 'PROPERTY_VALIDITY_TIME',
                'type' => 'number',

            ],
            [
                'id' => 'END_DATE',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.END'),
                'default' => true,
                'sort' => 'PROPERTY_END_DATE',
                'type' => 'number',

            ],
            [
                'id' => 'CARD_SECRET',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.SECRET'),
                'default' => true,
            ],

        ];

        return $arr;
    }

    /**
     * Метод возвращает ID инфоблока по символьному коду
     *
     * @param $code
     *
     * @return int|void
     * @throws Exception
     */
    public static function getIBlockIdByCode($code)
    {

        $IB = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code],
            'limit' => '1',
            'cache' => ['ttl' => 3600],
        ]);


        $return = $IB->fetch();
        if (!$return) {
            throw new Exception('IBlock with code"' . $code . '" not found');
        }
        return $return['ID'];
    }


    /**
     * Возвращает единственный экземпляр настроек грида.
     *
     * @return GridOptions
     */
    private function getObGridParams(): GridOptions
    {
        return $this->gridOption ?? $this->gridOption = new GridOptions($this->getGridId());
    }

    /**
     * Параметры навигации грида
     *
     * @return PageNavigation
     */
    private function getGridNav(): PageNavigation
    {
        if ($this->gridNav === null) {
            $this->gridNav = new PageNavigation($this->getGridId());
            $this->gridNav->allowAllRecords(true)->setPageSize($this->getObGridParams()->GetNavParams()['nPageSize'])
                ->initFromUri();
        }

        return $this->gridNav;
    }

    /**
     * Возвращает значения грид фильтра.
     *
     * @return array
     */
    public function getGridFilterValues(): array
    {
        $obFilterOption = new Options($this->getGridId());
        $arFilterData = $obFilterOption->getFilter([]);
        $baseFilter = array_intersect_key($arFilterData, array_flip($obFilterOption->getUsedFields()));
        $formatedFilter = $this->prepareFilter($arFilterData, $baseFilter);
        return array_merge(
            $baseFilter,
            $formatedFilter
        );
    }

    /**
     * Подготавливает параметры фильтра
     * @param array $arFilterData
     * @param array $baseFilter
     * @return array
     */
    public function prepareFilter(array $arFilterData, &$baseFilter = []): array
    {
        $arFilter = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => $this->idIBlock,
        ];

        if (!empty($arFilterData['ID_from'])) {
            $arFilter['>=ID'] = (int)$arFilterData['ID_from'];
        }
        if (!empty($arFilterData['ID_to'])) {
            $arFilter['<=ID'] = (int)$arFilterData['ID_to'];
        }

        if (!empty($arFilterData['PROPERTY_PRICE_VALUE_from'])) {
            $arFilter['>=PROPERTY_PRICE_VALUE'] = (int)$arFilterData['PROPERTY_PRICE_VALUE_from'];
        }
        if (!empty($arFilterData['PROPERTY_PRICE_VALUE_to'])) {
            $arFilter['<=PROPERTY_PRICE_VALUE'] = (int)$arFilterData['PROPERTY_PRICE_VALUE_to'];
        }



        return $arFilter;
    }

}
