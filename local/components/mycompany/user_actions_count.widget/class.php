<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Entity\Query;
use Bitrix\Main\UserTable;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Localization\Loc;

class UserActionsCountWidget extends CBitrixComponent
{
    public function __construct($component = null)
    {
        parent::__construct($component);

        Loader::includeModule("highloadblock");
    }

    /**
     * @throws Exception
     */
    public function onPrepareComponentParams($params)
    {
        $params['NAME_TEMPLATE'] = $params['NAME_TEMPLATE'] ?: CSite::GetNameFormat(false);
        $params['DETAIL_URL'] = trim($params['DETAIL_URL']);
        $params['CACHE_TIME'] = $params['CACHE_TIME'] ?: 3600;

        if (!$params['DETAIL_URL'])
            $params['~DETAIL_URL'] = $params['DETAIL_URL'] = COption::GetOptionString('intranet', 'search_user_url', '/user/#ID#/');

        if (empty($params['HLB']))
            throw new Exception(Loc::getMessage('MTH_ERROR_PARAMETERS'));

        return $params;
    }

    /**
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     * @throws \Bitrix\Main\ArgumentException
     */
    public function executeComponent()
    {
        if ($this->startResultCache($this->arParams['CACHE_TIME'])) {
            $entity = HighloadBlockTable::compileEntity($this->arParams['HLB']);
            $entityDataClass = $entity->getDataClass();

            $this->arResult['COUNTS'] = [];
            $rows = $entityDataClass::query()
                ->setSelect(['UF_USER'])
                ->addSelect(Query::expr()->count('ID'), 'CNT')
                ->where('UF_DATE', '>=', $this->getDateFrom())
                ->setGroup('UF_USER')
                ->setOrder(['CNT' => 'DESC'])
                ->setLimit($this->arParams['COUNT'])
                ->fetchAll();
            foreach ($rows as $row) {
                $this->arResult['COUNTS'][$row['UF_USER']] = $row['CNT'];
            }

            $this->getUsers();

            $this->includeComponentTemplate();
        }
    }

    private function getDateFrom()
    {
        return (new DateTime())->add('-' . $this->arParams['DAYS_COUNT'] . ' days');
    }

    private function getUsers()
    {
        $this->arResult['USERS'] = [];
        if (count($this->arResult['COUNTS'])) {
            $users = UserTable::getList([
                'select' => ['*'],
                'filter' => [
                    'ID' => array_keys($this->arResult['COUNTS']),
                    '=ACTIVE' => 'Y',
                ]
            ])->fetchAll();
            foreach ($users as $user) {
                if ($user['PERSONAL_PHOTO']) {
                    $imageFile = CFile::GetFileArray($user['PERSONAL_PHOTO']);
                    if ($imageFile !== false) {
                        $user["PERSONAL_PHOTO"] = CFile::ResizeImageGet(
                            $imageFile,
                            array("width" => 100, "height" => 100),
                            BX_RESIZE_IMAGE_EXACT,
                            true
                        );
                    } else
                        $user["PERSONAL_PHOTO"] = false;
                }
                $user['DETAIL_URL'] = str_replace(array('#ID#', '#USER_ID#'), $user['ID'], $this->arParams['DETAIL_URL']);

                $this->arResult['USERS'][$user["ID"]] = $user;
            }
        }
    }
}
