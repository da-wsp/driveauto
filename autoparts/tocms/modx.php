<?if(!defined("TDM_PROLOG_INCLUDED") || TDM_PROLOG_INCLUDED!==true)die();

$_REQUEST['q']='catalog';

$_SERVER['SCRIPT_NAME']='/index.php';
$_SERVER['REQUEST_URI']='/';
chdir($_SERVER["DOCUMENT_ROOT"]);
include($_SERVER["DOCUMENT_ROOT"]."/index.php");

/*



1 ----------------------------------------------------------------------------
� ������� ModX ������� ����� ������ (�����, ������� ������� � ������ �����)
��������->���������� ����������->������� (������� � ���� ��� �������� � ��)
������ �������:

{{header}}
{{main-menu}}
<div class="lmn">
	{{left-menu}}
</div>
<div class="content">
	[!TDMod3!]	
</div>
{{footer}}

� ��������� ������� ������ �������� "���������" (�������� 'catalog') ����� ������� (��� ��� ������).


2 ----------------------------------------------------------------------------
��������� "���������" (��� ��������) ����� ������� � \autoparts\tocms\ModX.php
��������:
$_REQUEST['q']='catalog';
(����������� ������� ModX �� ��������� ��� ������ � /.htaccess)


3 ----------------------------------------------------------------------------
������� ����� �������: TDMod3
(��������->���������� ����������->�������)
� ����������:
<?php
global $TDMContent;
echo $TDMContent;
?>


4 ----------------------------------------------------------------------------
�������� � ����� ������ ����������� title, description � keywords (��������� php ������������ �������: TDM_TITLE, TDM_KEYWORDS, TDM_DESCRIPTION)
(��������->���������� ����������->�����->header)
��������:
<title>[[if? is=`[*id*]:is:7` &then=`[[TDM_TITLE]]` &else=`[*pagetitle*]` ]]</title>
<meta name="description" content="[[if? is=`[*id*]:is:7` &then=`[[TDM_DESCRIPTION]]` &else=`[*pagetitle*]` ]]" />
<meta name="keywords" content="[[if? is=`[*id*]:is:7` &then=`[[TDM_KEYWORDS]]` &else=`[*pagetitle*]` ]]" />

��� is:7 ��� id �������



�����:
������� � ����� ������ ������� ModX ���:
<base href=
��� �� ������� �� ���������� �� ��� ������ �������� ModX ���� ������ /autoparts/


*/
?>