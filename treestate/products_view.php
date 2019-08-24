<?php
// This script and data application was edit by Dennis Kipkemboi from appgini tamplet
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/products.php");
	include("$currDir/products_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('products');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php\'", 2000);</script>';
		exit;
	}
    $x = new DataList;
	$x->TableName = "products";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`products`.`id`" => "id",
        "`products`.`name`" => "name",
        "`products`.`cost`" => "cost",
        "`products`.`weight`" => "weight",
        "`products`.`quantity`" => "quantity",
        "`products`.`quantity`" => "quantity",
        "`products`.`category`" => "category",
        "`products`.`brand`" => "brand",
        "`products`.`status`" => "status",
        "`products`.`ico`" => "ico",
        "`products`.`serial`" => "serial"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`products`.`id`',
		2 => 2,
		3 => '`products`.`category`',
		4 => '`products`.`status`',
		5 => 5
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`products`.`id`" => "id",
		"`products`.`name`" => "name",
		"`products`.`cost`" => "cost",
		"`products`.`weight`" => "weight",
		"`products`.`quantity`" => "quantity",
		"`products`.`category`" => "category",
		"`products`.`brand`" => "brand",
		"`products`.`status`" => "status",
		"`products`.`ico`" => "ico",
		"`products`.`serial`" => "serial"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`products`.`id`" => "ID",
		"`products`.`name`" => "Name",
		"`products`.`cost`" => "Cost",
		"`products`.`weight`" => "Weight",
		"`products`.`quantity`" => "Quantity",
		"`products`.`brand`" => "Brand"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`products`.`id`" => "id",
		"`products`.`name`" => "name",
		"`products`.`cost`" => "cost"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`products` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 0;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 60;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "products_view.php";
	$x->RedirectAfterInsert = "products_view.php?SelectedID=#ID#";
	$x->TableTitle = "Products";
	$x->TableIcon = "resources/table_icons/building.png";
	$x->PrimaryKey = "`products`.`id`";

	$x->ColWidth   = array(150, 150, 150, 150, 150);
	$x->ColCaption = array("Name" , "Cost", "Weight", "Quantity", "Status");
	$x->ColFieldName = array('name', "cost", "weight", "quantity", "status");
	$x->ColNumber  = array(2, 3);

	// template paths below are based on the app main directory
	$x->Template = 'templates/products_templateTV.html';
	$x->SelectedTemplate = 'templates/products_templateTVS.html';
	$x->TemplateDV = 'templates/products_templateDV.html';
	$x->TemplateDVP = 'templates/products_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `products`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='products' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `products`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='products' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`products`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: products_init
	$render=TRUE;
	if(function_exists('products_init')){
		$args=array();
		$render=products_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: products_header
	$headerCode='';
	if(function_exists('products_header')){
		$args=array();
		$headerCode=products_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: products_footer
	$footerCode='';
	if(function_exists('products_footer')){
		$args=array();
		$footerCode=products_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>