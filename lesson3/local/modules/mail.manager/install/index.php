<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;
use Bitrix\Main\ModuleManager;

/**
 * Class mail_manager
 * Модуль хранения email адресов
 */
class mail_manager extends CModule
{
    /**
     * Индификатор модуля
     * @var string
     */
    public $MODULE_ID = 'mail.manager';


    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('RF_MAIL_MANAGER_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('RF_MAIL_MANAGER_MODULE_DESCRIPTION');
    }

    /**
     * @param bool $bNotDocumentRoot
     * @return mixed|string
     */
    public function GetPath($bNotDocumentRoot = false)
    {
        if ($bNotDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', str_replace('\\', '/', dirname(__DIR__)));
        }

        return dirname(__DIR__);
    }

    /**
     * @return bool|void
     */
    public function DoInstall()
    {
        $this->installDB();
        $this->installFiles();

        ModuleManager::registerModule($this->MODULE_ID);

        return true;
    }

    /**
     * @return bool|void
     */
    public function DoUninstall()
    {
        $this->uninstallDB();
        $this->uninstallFiles();

        ModuleManager::unregisterModule($this->MODULE_ID);

        return true;
    }

    /**
     * @param array $arParams
     * @return bool|void
     */
    public function installFiles($arParams = array())
    {
        $root = Application::getDocumentRoot();

        CopyDirFiles(__DIR__ . '/components/', $root . '/local/components', true, true);

        if (is_dir($sPachDir = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/admin')) {
            if ($sDir = opendir($sPachDir)) {
                while (false !== $sItem = readdir($sDir)) {
                    if ($sItem == '..' || $sItem == '.' || $sItem == 'menu.php') {
                        continue;
                    }

                    file_put_contents($file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $sItem,
                        '<' . '? require($_SERVER["DOCUMENT_ROOT"] . "/local/modules/' . $this->MODULE_ID . '/admin/' . $sItem . '");?' . '>');
                }

                closedir($sDir);
            }
        }


        return true;
    }

    /**
     * @return bool|void
     */
    public function uninstallFiles()
    {
        if (Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . $this->GetPath() . '/admin/',
                $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');

            if ($dir = opendir($path)) {
                while (false !== $item = readdir($dir)) {
                    File::deleteFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
                }

                closedir($dir);
            }
        }

        DeleteDirFiles(__DIR__ . "/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components");

        return true;
    }

    /**
     * @return bool
     */
    public function installDB()
    {
        $sPath = $this->getPath() . '/install/db/mysql/up/';
        $oConn = Application::getConnection();
        $arFiles = scandir($sPath, SCANDIR_SORT_NONE);

        foreach ($arFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $sQuery = file_get_contents($sPath . $file);
            $oConn->executeSqlBatch($sQuery);
        }

        return true;
    }

    /**
     * @return bool|void
     */
    public function uninstallDB()
    {
        $sPath = $this->getPath() . '/install/db/mysql/down/';
        $oConn = Application::getConnection();
        $arFiles = scandir($sPath, SCANDIR_SORT_NONE);

        foreach ($arFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $sQuery = file_get_contents($sPath . $file);
            $oConn->executeSqlBatch($sQuery);
        }

        return true;
    }
}