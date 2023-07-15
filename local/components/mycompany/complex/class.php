<?php if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

class Complex extends CBitrixComponent
{
    /** @var array Массив для задания псевдонимов по умолчанию переменных в режиме ЧПУ */
    public array $arDefaultVariableAliases404 = [];

    /** @var array Массив для задания псевдонимов по умолчанию переменных в режиме не ЧПУ */
    public array $arDefaultVariableAliases = [];

    /** @var array Массив для задания путей по умолчанию для работы в ЧПУ режиме */
    public array $arDefaultUrlTemplates404 = [
        'list' => '',
        'detail' => '#ID#/',
    ];

    /** @var array Массив имен переменных, которые компонент может получать из запроса */
    public array $arComponentVariables = [
        'ID',
    ];

    public function executeComponent()
    {
        global $APPLICATION;

        $arVariables = [];
        if ($this->arParams['SEF_MODE'] == 'Y') {
            $arDefaultUrlTemplates404 = $this->arDefaultUrlTemplates404;
            $arDefaultVariableAliases404 = $this->arDefaultVariableAliases404;

            $arUrlTemplates = CComponentEngine::MakeComponentUrlTemplates(
                $arDefaultUrlTemplates404,
                $this->arParams['SEF_URL_TEMPLATES']
            );

            $arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
                $arDefaultVariableAliases404,
                $this->arParams['VARIABLE_ALIASES']
            );

            $componentPage = CComponentEngine::ParseComponentPath(
                $this->arParams['SEF_FOLDER'],
                $arUrlTemplates,
                $arVariables
            );

            if ( ! $componentPage) {
                $componentPage = 'list';
            }

            CComponentEngine::InitComponentVariables(
                $componentPage,
                $this->arComponentVariables,
                $arVariableAliases,
                $arVariables
            );

            $this->arResult['FOLDER'] = $this->arParams['SEF_FOLDER'];
            $this->arResult['URL_TEMPLATES'] = $arUrlTemplates;
        } else {
            $arDefaultVariableAliases = $this->arDefaultVariableAliases;

            $arVariableAliases = CComponentEngine::MakeComponentVariableAliases(
                $arDefaultVariableAliases,
                $this->arParams['VARIABLE_ALIASES']
            );

            CComponentEngine::InitComponentVariables(
                false,
                $this->arComponentVariables,
                $arVariableAliases,
                $arVariables
            );

            if (isset($arVariables['ID']) && intval($arVariables['ID']) > 0) {
                $componentPage = 'detail';
            } else {
                $componentPage = 'list';
            }

            $sGetCurPage = htmlspecialchars($APPLICATION->GetCurPage());

            $this->arResult['FOLDER'] = '';
            $this->arResult['URL_TEMPLATES'] = [
                'list' => $sGetCurPage,
                'detail' => $sGetCurPage . '?' . $arVariableAliases['ID'] . '=#ID#',
            ];
        }

        $this->arResult['VARIABLES'] = $arVariables;
        $this->arResult['ALIASES'] = $arVariableAliases;
        $this->arResult['CURRENT_TEMPLATE'] = $componentPage;

        $this->includeComponentTemplate($componentPage);
    }
}
