<?php

namespace Mail\Manager;

use Mail\Manager\Orm\EmailsTable;
use Bitrix\Main\Localization\Loc;
use Mail\Manager\Orm\AddressesTable;

/**
 * Class Profile
 * @package YLab\Mail
 */
class Addresses
{
    /**
     * Список профилей
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getAddresses()
    {
        $result = [];
        $result['CLASS_NAME'] = 'Addresses';

        $result['HEADER']['ID'] = Loc::getMessage('RF_MAIL_MANAGER_ADDRESSES_HEAD_ID');
        $result['HEADER']['COUNTRY'] = Loc::getMessage('RF_MAIL_MANAGER_ADDRESSES_HEAD_COUNTRY');
        $result['HEADER']['ADDRESS'] = Loc::getMessage('RF_MAIL_MANAGER_ADDRESSES_HEAD_ADDRESS');
        $result['HEADER']['PHONE_NUMBER'] = Loc::getMessage('RF_MAIL_MANAGER_ADDRESSES_HEAD_PHONE_NUMBER');

        $arParams = [
            'select' => [
                'ID' ,
                'COUNTRY',
                'ADDRESS', //=> '\Mail\Manager\Orm\AddressesTable:EMAILS.ADDRESS',
                'PHONE_NUMBER' //=> '\Mail\Manager\Orm\AddressesTable:EMAILS.PHONE_NUMBER'
            ]
        ];

        $oProfiles = AddressesTable::getList($arParams);


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
        $arProfile = AddressesTable::getById($iProfileID)->fetchAll();

        if (isset($arProfile[0]['ID']) && is_numeric($arProfile[0]['ID'])) {
            return $arProfile[0];
        }

        return false;
    }

    /**
     * Добавляем профиль
     */
    public function addAddress($arFields = [])
    {
        $result = AddressesTable::add([
            'COUNTRY' => 'Россия',
            'ADDRESS' => 'Пугачева, 11',
            'PHONE_NUMBER' => '88005553535'
        ]);

        return $result;
    }

    /**
     * Обновляем профиль
     */
    public function updateAddress($iProfileID = 0, $arFields = [])
    {
        $result = AddressesTable::update(1, [
            'COUNTRY' => 'Россия',
            'ADDRESS' => 'Пугачева, 11',
            'PHONE_NUMBER' => '88005553535'
        ]);

        return $result;

    }

    /**
     * Удаляем профиль
     */
    public function deleteAddress($iProfileID = 0)
    {
        $result = AddressesTable::delete(3);

        return $result;
    }
}