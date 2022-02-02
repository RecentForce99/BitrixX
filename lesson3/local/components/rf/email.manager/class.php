<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Mail\Manager\Profile;
use Mail\Manager\Addresses;
use \Mail\Manager\Orm\EmailsTable;
use Mail\Manager\Connection;
use Bitrix\Main\Loader;
use Bitrix\Iblock\IblockTable;
use \Bitrix\Main\ArgumentException;
use \Bitrix\Main\Grid\Options as GridOptions;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\UI\PageNavigation;
use \CBitrixComponent;
use \CIBlockElement;
use \Exception;
use \Bitrix\Main\UI\Filter\Options;

/**
 * Class ProfileManager
 */
class EmailManagerComponent extends CBitrixComponent
{
    /**
     * @return mixed|void
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */

    /** @var int $idIBlock ID информационного блока */
    private $idIBlock;

    /** @var string $templateName Имя шаблона компонента */
    private $templateName;

    /** @var array $emails Данные из третьего задания */
    private $emails;

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

    public function executeComponent()
    {
        Loader::includeModule('mail.manager');

        $connection = new Connection();

        $profile = new Profile();
        $addresses = new Addresses();

        $this->emails = $connection->getConnection();
        $this->idIBlock = '';

        //Добавление записи в талбицу
        //$result = $profile->addProfile();
        //$result = $addresses->addAddress();

        //Обновление записи в талбице
        //$result = $profile->updateProfile();
        //$result = $addresses->updateAddress();

        //Удаление записи из талбицы
        //$result = $profile->deleteProfile();
        //$result = $addresses->deleteAddress();

        if ($this->templateName == 'grid') {
            $this->showByGrid();

            $this->emails;

        } else {
            $this->arResult = $connection->getConnection();
        }

        //if($result->isSuccess())
        //{
        //    $id = $result->getId();
        //    echo $this->arResult = 'Запись добавлена с id = '.$id;
        //}
        //else
        //{
        //    $error = $result->getErrorMessages();
        //    echo $this->arResult = 'Произошла ошибка при добавлении: <pre>'.var_export($error, true).'</pre>';
        //}

        $this->includeComponentTemplate();
    }

    public function getElements(): array
    {
        $result = [];

        if (!$this->getGridNav()->allRecordsShown()) {
            $arNav['iNumPage'] = $this->getGridNav()->getCurrentPage();
            $arNav['nPageSize'] = $this->getGridNav()->getPageSize();
        } else {
            $arNav = false;
        }

        $arFilter = $this->getGridFilterValues();

        $arCurSort = $this->getObGridParams()->getSorting(['sort' => ['ID' => 'DESC']])['sort'];

        $elements = CIBlockElement::GetList(
            $arCurSort,
            $arFilter,
            false,
            $arNav,
            [
                'ID',
                'IBLOCK_ID',
                'PROPERTY_NAME',
                'PROPERTY_EMAIL',
                'PROPERTY_COUNTRY',
                'PROPERTY_ADDRESS',
                'PROPERTY_PHONE_NUMBER',

            ]
        );


        while ($element = $elements->GetNext()) {

            $result[] = [
                'ID' => $element['ID'],
                'NAME' => $element['PROPERTY_NAME_VALUE'],
                'EMAIL' => $element['PROPERTY_EMAIL_VALUE'],
                'COUNTRY' => $element['PROPERTY_COUNTRY_VALUE'],
                'ADDRESS' => $element['PROPERTY_ADDRESS_VALUE'],
                'PHONE_NUMBER' => $element['PROPERTY_PHONE_NUMBER_VALUE'],
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

        $this->arResult['GRID_HEAD'] = $this->selectGridHead();

        $this->arResult['GRID_NAV'] = $this->getGridNav();
        $this->arResult['GRID_FILTER'] = $this->getGridFilterParams();

        $this->arResult['BUTTONS']['ADD']['NAME'] = Loc::getMessage('YLAB.CARD.LIST.CLASS.ADD');
    }

    /**
     * Возвращает содержимое (тело) таблицы.
     *
     * @return array
     */
    private function getGridBody(): array
    {
        $arBody = [];

        foreach ($this->emails['PROFILES'] as $arItem)
        {
            $arGridElement = [];
            switch ($this->emails['CLASS_NAME'])
            {
                case 'Connection':
                    $arGridElement['data'] = [
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'EMAIL' => $arItem['EMAIL'],
                        'COUNTRY' => $arItem['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_COUNTRY'],
                        'ADDRESS' => $arItem['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_ADDRESS'],
                        'PHONE_NUMBER' => $arItem['MAIL_MANAGER_ORM_CONNECTION_ADDRESSES_PHONE_NUMBER'],
                    ];
                    break;

                case 'Addresses':
                    $arGridElement['data'] = [
                        'ID' => $arItem['ID'],
                        'COUNTRY' => $arItem['COUNTRY'],
                        'ADDRESS' => $arItem['ADDRESS'],
                        'PHONE_NUMBER' => $arItem['PHONE_NUMBER'],
                    ];
                    break;

                case 'Profile':
                    $arGridElement['data'] = [
                        'ID' => $arItem['ID'],
                        'NAME' => $arItem['NAME'],
                        'EMAIL' => $arItem['EMAIL'],
                    ];
                    break;

            }
            $arGridElement['actions'] = [
                [
                    'text' => Loc::getMessage('RF.CARD.LIST.CLASS.EDIT'),
                    'onclick' =>  ''
                ],
                [
                    'text' => Loc::getMessage('RF.CARD.LIST.CLASS.DELETE'),
                ]
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
        return 'rf_email_manager_' . $this->idIBlock;
    }

    /**
     * Возращает заголовки таблицы.
     *
     * @return array
     */

    private function selectGridHead() : array
    {
        $arr = $this->getGridHead();
        switch ($this->emails['CLASS_NAME'])
        {
            case 'Connection':
                return $arr['Connection'];
                break;

            case 'Addresses':
                return $arr['Address'];
                break;

            case 'Profile':
                return $arr['Profile'];
                break;


        }
    }

    private function getGridHead(): array
    {
        return [
            'Address' => [
                [
                    'id' => 'ID',
                    'name' => 'ID',
                    'default' => true,
                    'sort' => 'ID',
                    'type' => 'number',
                ],
                [
                    'id' => 'COUNTRY',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.COUNTRY'),
                    'default' => true,
                    'sort' => 'PROPERTY_COUNTRY',
                    'type' => 'string',

                ],
                [
                    'id' => 'ADDRESS',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.ADDRESS'),
                    'default' => true,
                    'sort' => 'PROPERTY_ADDRESS',
                    'type' => 'string'

                ],
                [
                    'id' => 'PHONE_NUMBER',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.PHONE_NUMBER'),
                    'default' => true,
                    'sort' => 'PROPERTY_PHONE_NUMBER',
                    'type' => 'number',

                ],

            ],
            'Profile' => [
                [
                    'id' => 'ID',
                    'name' => 'ID',
                    'default' => true,
                    'sort' => 'ID',
                    'type' => 'number',
                ],
                [
                    'id' => 'NAME',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.NAME'),
                    'default' => true,
                    'sort' => 'PROPERTY_NAME',
                    'type' => 'string',

                ],
                [
                    'id' => 'EMAIL',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.EMAIL'),
                    'default' => true,
                    'sort' => 'PROPERTY_EMAIL',
                    'type' => 'string',

                ],
            ],

            'Connection' => [
                [
                    'id' => 'ID',
                    'name' => 'ID',
                    'default' => true,
                    'sort' => 'ID',
                    'type' => 'number',
                ],
                [
                    'id' => 'NAME',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.NAME'),
                    'default' => true,
                    'sort' => 'PROPERTY_NAME',
                    'type' => 'string',

                ],
                [
                    'id' => 'EMAIL',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.EMAIL'),
                    'default' => true,
                    'sort' => 'PROPERTY_EMAIL',
                    'type' => 'string',

                ],
                [
                    'id' => 'COUNTRY',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.ADDRESS'),
                    'default' => true,
                    'sort' => 'PROPERTY_COUNTRY',
                    'type' => 'string'

                ],
                [
                    'id' => 'ADDRESS',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.ADDRESS'),
                    'default' => true,
                    'sort' => 'PROPERTY_ADDRESS',
                    'type' => 'string'

                ],
                [
                    'id' => 'PHONE_NUMBER',
                    'name' => Loc::getMessage('RF.CARD.LIST.CLASS.PHONE_NUMBER'),
                    'default' => true,
                    'sort' => 'PROPERTY_PHONE_NUMBER',
                    'type' => 'number',

                ],
            ]

        ];
    }

    /**
     * Метод возвращает ID инфоблока по символьному коду
     *
     * @param $code
     *
     * @return int|void
     * @throws Exception
     */

    /**
     * Возвращает настройки отображения грид фильтра.
     *
     * @return array
     */
    private function getGridFilterParams(): array
    {

        return [
            [
                'id' => 'ID',
                'name' => 'ID',
                'type' => 'number'
            ],
            [
                'id' => 'NAME',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.NAME'),
                'type' => 'string'
            ],
            [
                'id' => 'EMAIL',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.EMAIL'),
                'type' => 'string',

            ],
            [
                'id' => 'ADDRESS',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.ADDRESS'),
                'type' => 'string'

            ],
            [
                'id' => 'PHONE_NUMBER',
                'name' => Loc::getMessage('RF.CARD.LIST.CLASS.PHONE_NUMBER'),
                'type' => 'number',

            ],

        ];


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

        if (!empty($arFilterData['PROPERTY_COUNTRY_VALUE_from'])) {
            $arFilter['>=PROPERTY_COUNTRY'] = (int)$arFilterData['PROPERTY_COUNTRY_VALUE_from'];
        }
        if (!empty($arFilterData['PROPERTY_COUNTRY_VALUE_to'])) {
            $arFilter['<=PROPERTY_COUNTRY'] = (int)$arFilterData['PROPERTY_COUNTRY_VALUE_to'];
        }


        return $arFilter;
    }


}

