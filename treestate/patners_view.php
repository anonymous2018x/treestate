<?php
// This script and data application were generated by AppGini 5.62
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/patners.php");
	include("$currDir/patners_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('patners');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "patners";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`patners`.`id`" => "id",
		"`patners`.`last_name`" => "last_name",
		"`patners`.`first_name`" => "first_name",
		"`patners`.`gender`" => "gender",
		"if(`patners`.`birth_date`,date_format(`patners`.`birth_date`,'%m/%d/%Y'),'')" => "birth_date",
		"`patners`.`age`" => "age",
		"`patners`.`image`" => "image",
		"`patners`.`city`" => "city",
		"CONCAT_WS('-', LEFT(`patners`.`mobile`,4), MID(`patners`.`mobile`,5,9))" => "mobile",
		"`patners`.`product`" => "product",
		"`patners`.`brand`" => "brand",
		"DATE_FORMAT(`patners`.`filed`, '%c/%e/%Y %l:%i%p')" => "filed",
		"DATE_FORMAT(`patners`.`last_modified`, '%c/%e/%Y %l:%i%p')" => "last_modified"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`patners`.`id`',
		2 => 2,
		3 => '`patners`.`birth_date`',
		4 => 4,
		5 => 5,
		6 => '`patners`.`age`',
		7 => 7,
		8 => '`patners`.`city`',
		9 => '`patners`.`mobile`',
		10 => '`patners`.`product`',
		11 => '`patners`.`brand`',
		12 => '`patners`.`filed`',
		13 => '`patners`.`last_modified`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`patners`.`id`" => "id",
		"`patners`.`last_name`" => "last_name",
		"`patners`.`first_name`" => "first_name",
		"`patners`.`gender`" => "gender",
		"if(`patners`.`birth_date`,date_format(`patners`.`birth_date`,'%m/%d/%Y'),'')" => "birth_date",
		"`patners`.`age`" => "age",
		"`patners`.`image`" => "image",
		"`patners`.`city`" => "city",
		"CONCAT_WS('-', LEFT(`patners`.`mobile`,3), MID(`patners`.`mobile`,4,3))" => "mobile",
		"`patners`.`product`" => "product",
		"`patners`.`brand`" => "brand",
		"DATE_FORMAT(`patners`.`filed`, '%c/%e/%Y %l:%i%p')" => "filed",
		"DATE_FORMAT(`patners`.`last_modified`, '%c/%e/%Y %l:%i%p')" => "last_modified"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`patners`.`id`" => "ID",
		"`patners`.`last_name`" => "Last name",
		"`patners`.`first_name`" => "First name",
		"`patners`.`gender`" => "Gender",
		"`patners`.`birth_date`" => "Birth date",
		"`patners`.`age`" => "Age",
		"`patners`.`city`" => "City",
		"`patners`.`mobile`" => "Mobile",
		"`patners`.`product`" => "Product",
		"`patners`.`brand`" => "Brand",
		"`patners`.`filed`" => "Filed",
		"`patners`.`last_modified`" => "Last modified"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`patners`.`id`" => "id",
		"`patners`.`last_name`" => "last_name",
		"`patners`.`first_name`" => "first_name",
		"`patners`.`gender`" => "gender",
		"if(`patners`.`birth_date`,date_format(`patners`.`birth_date`,'%m/%d/%Y'),'')" => "birth_date",
		"`patners`.`age`" => "age",
		"`patners`.`city`" => "city",
		"CONCAT_WS('-', LEFT(`patners`.`mobile`,3), MID(`patners`.`mobile`,4,3))" => "mobile",
		"`patners`.`product`" => "product",
		"`patners`.`brand`" => "brand",
		"DATE_FORMAT(`patners`.`filed`, '%c/%e/%Y %l:%i%p')" => "filed",
		"DATE_FORMAT(`patners`.`last_modified`, '%c/%e/%Y %l:%i%p')" => "last_modified"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`patners` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = false;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 1;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 20;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "patners_view.php";
	$x->RedirectAfterInsert = "patners_view.php?SelectedID=#ID#";
	$x->TableTitle = "Patners";
	$x->TableIcon = "resources/table_icons/administrator.png";
	$x->PrimaryKey = "`patners`.`id`";
	$x->DefaultSortField = '1';
	$x->DefaultSortDirection = 'desc';

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Last name", "First name", "City", "Product", "Brand", "Mobile");
	$x->ColFieldName = array('last_name', 'first_name', 'city', 'product', 'brand', 'mobile');
	$x->ColNumber  = array(2, 3, 8, 10, 11, 9);

	// template paths below are based on the app main directory
	$x->Template = 'templates/patners_templateTV.html';
	$x->SelectedTemplate = 'templates/patners_templateTVS.html';
	$x->TemplateDV = 'templates/patners_templateDV.html';
	$x->TemplateDVP = 'templates/patners_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->ShowRecordSlots = 0;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `patners`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='patners' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `patners`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='patners' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`patners`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: patners_init
	$render=TRUE;
	if(function_exists('patners_init')){
		$args=array();
		$render=patners_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: patners_header
	$headerCode='';
	if(function_exists('patners_header')){
		$args=array();
		$headerCode=patners_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}
	
	echo $x->HTML;


	// hook: patners_footer
	$footerCode='';
	if(function_exists('patners_footer')){
		$args=array();
		$footerCode=patners_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
	
?>