<?php
// This script and data application was edit by Dennis Kipkemboi from appgini tamplet
// Download AppGini for free from https://bigprof.com/appgini/download/

	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/locations.php");
	include("$currDir/locations_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('locations');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php\'", 2000);</script>';
		exit;
	}
    $x = new DataList;
	$x->TableName = "locations";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`locations`.`id`" => "id",
        "`locations`.`town`" => "town",
        "`locations`.`estate`" => "estate",
        "`locations`.`point`" => "point"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`locations`.`id`',
		2 => 2,
		3 => '`locations`.`estate`',
		4 => '`locations`.`point`',
		5 => '`locations`.`town`'
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`locations`.`id`" => "id",
        "`locations`.`town`" => "town",
        "`locations`.`estate`" => "estate",
        "`locations`.`point`" => "point"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`locations`.`id`" => "id",
        "`locations`.`town`" => "Town",
        "`locations`.`estate`" => "Estate",
        "`locations`.`point`" => "Point"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`locations`.`id`" => "id",
        "`locations`.`town`" => "town",
        "`locations`.`estate`" => "estate",
        "`locations`.`point`" => "point"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array();

	$x->QueryFrom = "`locations` ";
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
	$x->ScriptFileName = "locations_view.php";
	$x->RedirectAfterInsert = "locations_view.php?SelectedID=#ID#";
	$x->TableTitle = "Locations";
	$x->TableIcon = "resources/table_icons/building.png";
	$x->PrimaryKey = "`locations`.`id`";

	$x->ColWidth   = array(150, 150, 150);
	$x->ColCaption = array("Town" , "Estate", "Point");
	$x->ColFieldName = array('town', "estate", "point");
	$x->ColNumber  = array(2, 3);

	// template paths below are based on the app main directory
	$x->Template = 'templates/locations_templateTV.html';
	$x->SelectedTemplate = 'templates/locations_templateTVS.html';
	$x->TemplateDV = 'templates/locations_templateDV.html';
	$x->TemplateDVP = 'templates/locations_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `locations`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='locations' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `locations`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='locations' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`locations`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: locations_init
	$render=TRUE;
	if(function_exists('locations_init')){
		$args=array();
		$render=locations_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: locations_header
	$headerCode='';
	if(function_exists('locations_header')){
		$args=array();
		$headerCode=locations_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: locations_footer
	$footerCode='';
	if(function_exists('locations_footer')){
		$args=array();
		$footerCode=locations_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>