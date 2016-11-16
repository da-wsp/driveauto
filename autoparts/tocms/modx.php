<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

$_REQUEST['q']='catalog';

$_SERVER['SCRIPT_NAME']='/index.php';
$_SERVER['REQUEST_URI']='/';
chdir($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"]."/index.php");

/*



1 ----------------------------------------------------------------------------
В админке ModX создать новый шаблон (шапка, боковые колонки и подвал сайта)
Элементы->Управление элементами->Шаблоны (шаблоны в этой цмс хранятся в БД)
Пример шаблона:

{{header}}
{{main-menu}}
<div class="lmn">
	{{left-menu}}
</div>
<div class="content">
	[!TDMod3!]	
</div>
{{footer}}

В свойствах ресурса шаблон написать "Псевдоним" (например 'catalog') этого шаблона (для ЧПУ ссылки).


2 ----------------------------------------------------------------------------
Прописать "Псевдоним" (ЧПУ название) этого шаблона в \autoparts\tocms\ModX.php
например:
$_REQUEST['q']='catalog';
(Подключение шаблона ModX по параметру ЧПУ смотри в /.htaccess)


3 ----------------------------------------------------------------------------
Создать новый сниппет: TDMod3
(Элементы->Управление элементами->Сниппет)
с сожержимым:
<?php
global $TDMContent;
echo $TDMContent;
?>


4 ----------------------------------------------------------------------------
Добавить в шапке шаблна определение title, description и keywords (константы php определенные модулем: TDM_TITLE, TDM_KEYWORDS, TDM_DESCRIPTION)
(Элементы->Управление элементами->Чанки->header)
например:
<title>[[if? is=`[*id*]:is:7` &then=`[[TDM_TITLE]]` &else=`[*pagetitle*]` ]]</title>
<meta name="description" content="[[if? is=`[*id*]:is:7` &then=`[[TDM_DESCRIPTION]]` &else=`[*pagetitle*]` ]]" />
<meta name="keywords" content="[[if? is=`[*id*]:is:7` &then=`[[TDM_KEYWORDS]]` &else=`[*pagetitle*]` ]]" />

где is:7 это id шаблона



Совет:
Удалите в шапке вашего шаблона ModX тэг:
<base href=
Что бы браузер не подставлял во все ссылки шаблонав ModX путь модуля /autoparts/


*/
?>