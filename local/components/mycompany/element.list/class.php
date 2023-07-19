<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Iblock\Elements\ElementQuestionTable;
use Bitrix\Main\Loader;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Main\Entity\Query;
use Bitrix\Main\Engine\CurrentUser;

class ElementList extends CBitrixComponent
{
    protected CurrentUser $currentUser;

    public function __construct($component = null)
    {
        parent::__construct($component);

        Loader::includeModule("iblock");

        $this->currentUser = CurrentUser::get();
    }

    public function onPrepareComponentParams($arParams)
    {
        $arParams['PAGE_SIZE'] = $arParams['PAGE_SIZE'] > 0 ? (int) $arParams['PAGE_SIZE'] : 20;
        $arParams['CACHE_TIME'] = $arParams['CACHE_TIME'] ?? 3600;

        return $arParams;
    }

    public function executeComponent()
    {
        global $CACHE_MANAGER;

        if ($this->startResultCache($this->arParams['CACHE_TIME'], [
            $this->arParams, $this->currentUser->getId(), $this->request->get('nav')
        ])) {
            $CACHE_MANAGER->RegisterTag("iblock_id_".ElementQuestionTable::getEntity()->getIblock()->getId());
            $pageNavigation = $this->getPageNavigation();

            $query = $this->getQuery($pageNavigation);

            $this->arResult['ITEMS'] = array_map(function ($item) {
                $item["STATUS"] = $item['STATUS_VALUE'];
                $item["DATE_CREATE"] = $item["DATE_CREATE"]->format("d.m.Y H:i");
                return $item;
            }, $query->fetchAll());

            $totalCount = $query->queryCountTotal();
            $pageNavigation->setRecordCount($totalCount);
            $this->arResult['NAV_OBJECT'] = $pageNavigation;

            $this->includeComponentTemplate();
        }
    }

    protected function getQuery(PageNavigation $pageNavigation)
    {
        $order = ['STATUS.VALUE' => 'asc', 'ID' => 'desc'];
        $query = ElementQuestionTable::query()
            ->setSelect([
                'ID',
                'NAME',
                'DATE_CREATE',
                'CREATED_BY',
                'ASSIGNED_VALUE' => 'ASSIGNED.VALUE',
                'STATUS_VALUE' => 'STATUS.VALUE',
            ])
            ->where('ACTIVE', 'Y')
            ->setOrder($order)
            ->setLimit($pageNavigation->getLimit())
            ->setOffset($pageNavigation->getOffset());

        $logic = Query::filter()->logic('OR');
        $logic->where('CREATED_BY', $this->currentUser->getId());
        $logic->where('ASSIGNED.VALUE', $this->currentUser->getId());
        $query->where($logic);

        return $query;
    }

    protected function getPageNavigation(): PageNavigation
    {
        $pageNavigation = new PageNavigation('nav');
        $pageNavigation->setPageSize($this->arParams['PAGE_SIZE'])->initFromUri();

        return $pageNavigation;
    }
}
