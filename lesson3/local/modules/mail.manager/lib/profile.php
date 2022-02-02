<?php

namespace Mail\Manager;

use Mail\Manager\Orm\EmailsTable;
use Bitrix\Main\Localization\Loc;

/**
 * Class Profile
 * @package YLab\Mail
 */
class Profile
{
    /**
     * Список профилей
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getProfiles()
    {
        $result = [];

        $result['CLASS_NAME'] = 'Profile';

        $result['HEADER']['ID'] = Loc::getMessage('RF_MAIL_MANAGER_PROFILE_HEAD_ID');
        $result['HEADER']['NAME'] = Loc::getMessage('RF_MAIL_MANAGER_PROFILE_HEAD_NAME');
        $result['HEADER']['EMAIL'] = Loc::getMessage('RF_MAIL_MANAGER_PROFILE_HEAD_EMAIL');
        $arParams = [
            'select' => [
                'ID' ,
                'NAME',
                'EMAIL',
            ]
        ];

        $oProfiles = EmailsTable::getList($arParams);


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
        $arProfile = EmailsTable::getById($iProfileID)->fetchAll();

        if (isset($arProfile[0]['ID']) && is_numeric($arProfile[0]['ID'])) {
            return $arProfile[0];
        }

        return false;
    }

    /**
     * Добавляем профиль
     */
    public function addProfile($arFields = [])
    {
        $result = EmailsTable::add([
            'NAME' => 'Дядюшка Боб',
            'EMAIL' => 'unclebob@gmail.com',
            'ADDRESSES_ID' => 5
        ]);

        return $result;
    }

    /**
     * Обновляем профиль
     */
    public function updateProfile($iProfileID = 0, $arFields = [])
    {
        $result = EmailsTable::update(1, [
            'NAME' => 'Линус Торвальдс',
            'EMAIL' => 'linux1981@mail.ru',
            'ADDRESSES_ID' => 1
        ]);

        return $result;

    }

    /**
     * Удаляем профиль
     */
    public function deleteProfile($iProfileID = 0)
    {
        $result = EmailsTable::delete(3);

        return $result;
    }
}