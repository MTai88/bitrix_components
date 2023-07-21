<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Iblock\Elements\ElementEventsTable;
use Bitrix\Iblock\Elements\ElementEventMemberTable;
use Bitrix\Main\Loader;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\Type\Date;
class MyeventsWidget extends CBitrixComponent
{
    private const CACHE_TIME = 36000;

    protected CurrentUser $currentUser;
    public function __construct($component = null)
    {
        parent::__construct($component);

        Loader::includeModule("iblock");

        $this->currentUser = CurrentUser::get();
    }

    public function executeComponent()
    {
        if ($this->startResultCache($this->arParams['CACHE_TIME'] ?? self::CACHE_TIME, [$this->currentUser->getId()])) {
            $this->arResult["EVENTS"] = $this->getEvents();
            $this->arResult["MY_EVENTS"] = $this->getEvents(true);

            $this->includeComponentTemplate();
        }
    }

    private function getEvents($userEvents = false):array
    {
        $filter = [
            "IBLOCK_TYPE" => "content",
            "IBLOCK_ID" => ElementEventsTable::getEntity()->getIblock()->getId(),
            "ACTIVE" => "Y",
            "CHECK_PERMISSIONS" => "Y",
            "MIN_PERMISSION" => 'R',
            ">=DATE_ACTIVE_FROM" => new Date()
        ];
        if($userEvents){
            $filter["ID"] = CIBlockElement::SubQuery("PROPERTY_EVENT", array(
                "IBLOCK_ID" => ElementEventMemberTable::getEntity()->getIblock()->getId(),
                "PROPERTY_USER" => $this->currentUser->getId(),
            ));
        }
        $sort = ["DATE_ACTIVE_FROM" => "asc"];
        $res = CIBlockElement::GetList($sort, $filter, false, ['nTopCount' => $this->arParams["COUNT"]]);

        $items = [];
        while ($ob = $res->GetNextElement()) {
            $fields = $ob->GetFields();
            $fields["PROPERTIES"] = $ob->GetProperties();

            $fields["DATE"] = $this->getDateData($fields["DATE_ACTIVE_FROM"]);
            $fields = $this->getImage($fields);

            $items[] = $fields;
        }

        return $items;
    }

    private function getImage($item): array
    {
        if ($item['PREVIEW_PICTURE']) {
            $imageFile = \CFile::GetFileArray($item['PREVIEW_PICTURE']);
            if ($imageFile !== false) {
                $item["PREVIEW_PICTURE"] = \CFile::ResizeImageGet(
                    $imageFile,
                    array("width" => 100, "height" => 80),
                    BX_RESIZE_IMAGE_EXACT,
                    true
                );
            } else
                $item["PREVIEW_PICTURE"] = false;
        }

        return $item;
    }

    private function getDateData($activeFrom): string
    {
        $date = FormatDate('X', strtotime($activeFrom));
        return str_replace(' в 00:00', '', $date);
    }
}

