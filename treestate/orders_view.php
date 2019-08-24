<?php
// This script and data application was edit by Dennis Kipkemboi from appgini tamplet
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/orders.php");
	include("$currDir/orders_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('orders');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php\'", 2000);</script>';
		exit;
	}
    $x = new DataList;
	$x->TableName = "orders";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`orders`.`id`" => "id",
        "`orders`.`product`" => "product",
        "`orders`.`brand`" => "brand",
        "`orders`.`mobile`" => "mobile"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`orders`.`id`',
		2 => 2,
		3 => '`orders`.`estate`',
		4 => '`orders`.`point`',
		5 => '`orders`.`town`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
        "`orders`.`id`" => "id",
        "`orders`.`product`" => "product",
        "`orders`.`client`" => "client",
        "`orders`.`mobile`" => "mobile",
        "`orders`.`brand`" => "brand",
        "`orders`.`quantity`" => "quantity",
        "`orders`.`amount`" => "amount",
        "`orders`.`price`" => "price",
        "`orders`.`town`" => "town",
        "`orders`.`estate`" => "estate",
        "`orders`.`point`" => "point"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`orders`.`id`" => "id",
        "`orders`.`town`" => "Town",
        "`orders`.`estate`" => "Estate",
        "`orders`.`point`" => "Point"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`orders`.`id`" => "id",
        "`orders`.`town`" => "town",
        "`orders`.`estate`" => "estate",
        "`orders`.`point`" => "point"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`orders` ";
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
	$x->ScriptFileName = "orders_view.php";
	$x->RedirectAfterInsert = "orders_view.php?SelectedID=#ID#";
	$x->TableTitle = "Orders";
	$x->TableIcon = "resources/table_icons/building.png";
	$x->PrimaryKey = "`orders`.`id`";

	$x->ColWidth   = array(150, 150, 150);
	$x->ColCaption = array("Product" , "Brand", "Mobile");
	$x->ColFieldName = array('product', "brand", "mobile");
	$x->ColNumber  = array(2, 3);

	// template paths below are based on the app main directory
	$x->Template = 'templates/orders_templateTV.html';
	$x->SelectedTemplate = 'templates/orders_templateTVS.html';
	$x->TemplateDV = 'templates/orders_templateDV.html';
	$x->TemplateDVP = 'templates/orders_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `orders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='orders' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `orders`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='orders' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`orders`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: orders_init
	$render=TRUE;
	if(function_exists('orders_init')){
		$args=array();
		$render=orders_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: orders_header
	$headerCode='';
	if(function_exists('orders_header')){
		$args=array();
		$headerCode=orders_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: orders_footer
	$footerCode='';
	if(function_exists('orders_footer')){
		$args=array();
		$footerCode=orders_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>