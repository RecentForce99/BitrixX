<?php

namespace Mail\Manager\Orm;

use Bitrix\Main\Entity;
use Bitrix\Main\Localization\Loc;
use Mail\Manager\Orm\AddressesTable;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;


/**
 * Class ProfilesTable
 * @package app\Orm
 */
class ConnectionTable extends Entity\DataManager
{
    /**
     * Returns DB table name for entity.
     * @return string
     */
    public static function getTableName()
    {
        return 'y_emails';
    }

    /**
     * Returns entity map definition.
     * @return array
     * @throws \Exception
     */
    public static function getMap()
    {
        return [
            (new Entity\IntegerField('ID', [
                'primary' => true,
                'autocomplete' => true,
                'title' => 'ID',
            ])),
            (new Entity\IntegerField('ADDRESSES_ID', array(
                    'required' => false
                )
            )),
            (new Entity\StringField('NAME', [
                'validation' => [__CLASS__, 'validateName'],
                'title' => Loc::getMessage('RF_MAIL_MANAGER_PROFILE_NAME_FIELD'),
            ])),
            (new Entity\StringField('EMAIL', [
                'title' => Loc::getMessage('RF_MAIL_MANAGER_PROFILE_EMAIL_FIELD'),
            ])),

            (new Entity\ReferenceField(
                'ADDRESSES',
                'Mail\Manager\Orm\AddressesTable',
                array('=this.ADDRESSES_ID' => 'ref.ID')))
                ->configureJoinType('inner')
//            (new OneToMany('MORE', AddressesTable::class, 'EMAILS'))
//            ->configureJoinType('inner')
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