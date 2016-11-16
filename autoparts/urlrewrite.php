<?
$arUrlRewrite = array( //TDMGenerateURL 
	//CRON auto import
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/import/(.+?)/([0-9]+).php#",
		"RULE"	=>	"ID=$2&KEY=$1",
	),
	//Section parts with pagination
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/(.+?)/(.+?)/(.+?)/(.+?)/(.)of=m([0-9]+);t([0-9]+);s([0-9]+)&page=([0-9]+)#",
		"RULE"	=>	"com=sectionparts&brand=$1&mod_name=$2&type_name=$3&sec_name=$4&subsec_name=$5&mod_id=$7&type_id=$8&sec_id=$9&page=$10",
		"CACHE"	=>	"$8_$9_p$10",
	),
	//Section parts
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/(.+?)/(.+?)/(.+?)/(.+?)/(.)of=m([0-9]+);t([0-9]+);s([0-9]+)#",
		"RULE"	=>	"com=sectionparts&brand=$1&mod_name=$2&type_name=$3&sec_name=$4&subsec_name=$5&mod_id=$7&type_id=$8&sec_id=$9",
		"CACHE"	=>	"$8_$9",
	),
	//Subsections
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/(.+?)/(.+?)/(.+?)/(.)of=m([0-9]+);t([0-9]+);s([0-9]+)#",
		"RULE"	=>	"com=subsections&brand=$1&mod_name=$2&type_name=$3&sec_name=$4&mod_id=$6&type_id=$7&sec_id=$8",
		"CACHE"	=>	"$7$8",
	),
	//Sections
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/(.+?)/(.+?)/(.)of=m([0-9]+);t([0-9]+)#",
		"RULE"	=>	"com=sections&brand=$1&mod_name=$2&type_name=$3&mod_id=$5&type_id=$6",
		"CACHE"	=>	"$6",
	),
	//Types 
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/(.+?)/(.)of=m([0-9]+)#",
		"RULE"	=>	"com=types&brand=$1&mod_name=$2&mod_id=$4",
		"CACHE"	=>	"$4",
	),
	//Analogs 
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/search/(.+?)/(.+?)/#",
		"RULE"	=>	"com=analogparts&article=$1&brand=$2",
		"CACHE"	=>	"$1$2",
	),
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/search/(.+?)/(.+?)#",
		"RULE"	=>	"com=analogparts&article=$1&brand=$2",
		"CACHE"	=>	"$1$2",
	),
	//Search 
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/search/(.+?)/#",
		"RULE"	=>	"com=searchparts&article=$1",
		"CACHE"	=>	"$1",
	),
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/search/(.+?)#",
		"RULE"	=>	"com=searchparts&article=$1",
		"CACHE"	=>	"$1",
	),
	//Models
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/(.+?)/#",
		"RULE"	=>	"com=models&brand=$1",
		"CACHE"	=>	"$1",
	),
	array(
		"CONDITION"	=>	"#^/".TDM_ROOT_DIR."/#",
		"RULE"	=>	"com=manufacturers&last=$1",
		"CACHE"	=>	"main",
	),
	
);
?>