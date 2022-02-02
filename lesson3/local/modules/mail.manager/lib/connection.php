<?php

namespace Mail\Manager;

use Mail\Manager\Orm\AddressesTable;
use Mail\Manager\Orm\EmailsTable;
use Mail\Manager\Orm\ConnectionTable;
use Bitrix\Main\Localization\Loc;

/**
 * Class Profile
 * @package YLab\Mail
 */
class Connection
{
    /**
     * Список профилей
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getConnection()
    {
        $result = [];

        $result['CLASS_NAME'] = 'Connection';

        $result['HEADER']['ID'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_ID');
        $result['HEADER']['NAME'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_NAME');
        $result['HEADER']['EMAIL'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_EMAIL');
        $result['HEADER']['ADDRESSES.COUNTRY'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_COUNTRY');
        $result['HEADER']['ADDRESSES.ADDRESS'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_ADDRESS');
        $result['HEADER']['ADDRESSES.PHONE_NUMBER'] = Loc::getMessage('RF_MAIL_MANAGER_CONNECTION_HEAD_PHONE_NUMBER');
        $arParams = [
            'select' => [
                'ID' ,
                'NAME',
                'EMAIL',
                'ADDRESSES.COUNTRY',
                'ADDRESSES.ADDRESS',
                'ADDRESSES.PHONE_NUMBER'
            ]
        ];

        $oProfiles = ConnectionTable::getList($arParams);


        if ($oProfiles->getSelectedRowsCount()) {
            while ($arProfile = $oProfiles->fetch()) {
                $result['PROFILES'][] = $arProfile;
            }
        }
        return $result;
    }

    /**
     * Получаем данные выбранного профиля
     * @param $iProfileID
     * @return bool
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getProfile($iProfileID)
    {
        $arProfile = ConnectionTable::getById($iProfileID)->fetchAll();

        if (isset($arProfile[0]['ID']) && is_numeric($arProfile[0]['ID'])) {
            return $arProfile[0];
        }

        return false;
    }

    public function addConnection($arFields = [])
    {
        $result = [
            EmailsTable::add([
            'NAME' => 'Дядюшка Боб',
            'EMAIL' => 'unclebob@gmail.com',
            'ADDRESSES_ID' => 1,
        ],
        AddressesTable::add([
            'COUNTRY' => 'Россия',
            'ADDRESS' => 'Пугачева, 11',
            'PHONE_NUMBER' => '88005553535'
        ]))
        ];

        return $result;
    }

    /**
     * Обновляем профиль
     */
    public function updateConnection($iProfileID = 0, $arFields = [])
    {
        $result = [
            EmailsTable::update(5, [
                'NAME' => 'Линус Торвальдс',
                'EMAIL' => 'linux1981@mail.ru',
            ]),
            AddressesTable::update(10, [
                'COUNTRY' => 'Россия',
                'ADDRESS' => 'Пугачева, 11',
                'PHONE_NUMBER' => '88005553535'
            ])
        ];

        return $result;

    }

    /**
     * Удаляем профиль
     */
    public function deleteConnection($iProfileID = 0)
    {
        $result = [
            EmailsTable::delete(7),
            AddressesTable::delete(7)
        ];

        return $result;
    }
}