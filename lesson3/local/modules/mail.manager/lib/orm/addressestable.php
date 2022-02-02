<?php

namespace Mail\Manager\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Mail\Manager\Orm\EmailsTable;


/**
 * Class ProfilesTable
 * @package app\Orm
 */
class AddressesTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     * @return string
     */
    public static function getTableName()
    {
        return 'y_addresses';
    }

    /**
     * Returns entity map definition.
     * @return array
     * @throws \Exception
     */
    public static function getMap()
    {
        return [
            new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID',
            ]),
            (new Entity\StringField('COUNTRY', [
                'title' => Loc::getMessage('RF_MAIL_MANAGER_ADDRESS_COUNTRY_FIELD')
            ])),
            new Entity\StringField('ADDRESS', [
                'title' => Loc::getMessage('RF_MAIL_MANAGER_ADDRESS_ADDRESS_FIELD')
            ]),
            new Entity\IntegerField('PHONE_NUMBER', [
                'title' => Loc::getMessage('RF_MAIL_MANAGER_ADDRESS_PHONE_NUMBER_FIELD')
            ])
//            (new Reference('EMAILS',
//                EmailsTable::class,
//                Join::on('this.EMAILS_ID', 'ref.ID')
//            ))->configureJoinType('inner')
        ];
    }

    /**
     * Returns validators for NAME field.
     * @return array
     * @throws \Bitrix\Main\ArgumentTypeException
     */
    public static function validateName()
    {
        return [
            new Entity\Validator\Length(null, 255),
        ];
    }
}
