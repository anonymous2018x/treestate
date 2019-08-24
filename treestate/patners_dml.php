<?php

// Data functions (insert, update, delete, form) for table patners

// This script and data application were generated by AppGini 5.62
// Download AppGini for free from https://bigprof.com/appgini/download/

function patners_insert(){
	global $Translation;

	// mm: can member insert record?
	$arrPerm=getTablePermissions('patners');
	if(!$arrPerm[1]){
		return false;
	}
	$data['last_name'] = makeSafe($_REQUEST['last_name']);
		if($data['last_name'] == empty_lookup_value){ $data['last_name'] = ''; }
	$data['first_name'] = makeSafe($_REQUEST['first_name']);
		if($data['first_name'] == empty_lookup_value){ $data['first_name'] = ''; }
	$data['gender'] = makeSafe($_REQUEST['gender']);
		if($data['gender'] == empty_lookup_value){ $data['gender'] = ''; }
	$data['birth_date'] = intval($_REQUEST['birth_dateYear']) . '-' . intval($_REQUEST['birth_dateMonth']) . '-' . intval($_REQUEST['birth_dateDay']);
	$data['birth_date'] = parseMySQLDate($data['birth_date'], '');
	$data['city'] = makeSafe($_REQUEST['city']);
		if($data['city'] == empty_lookup_value){ $data['city'] = ''; }
	$data['mobile'] = makeSafe($_REQUEST['mobile']);
		if($data['mobile'] == empty_lookup_value){ $data['mobile'] = ''; }
	$data['product'] = makeSafe($_REQUEST['product']);
		if($data['product'] == empty_lookup_value){ $data['product'] = ''; }
	$data['brand'] = makeSafe($_REQUEST['brand']);
		if($data['brand'] == empty_lookup_value){ $data['brand'] = ''; }
	$data['filed'] = parseCode('<%%creationDateTime%%>', true, true);
	$data['image'] = PrepareUploadedFile('image', 1024000,'jpg|jpeg|gif|png', false, '');
	if($data['image']) createThumbnail($data['image'], getThumbnailSpecs('patners', 'image', 'tv'));
	if($data['image']) createThumbnail($data['image'], getThumbnailSpecs('patners', 'image', 'dv'));
	
	if($data['last_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Last name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['first_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'First name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['gender'] == '') $data['gender'] = "Unknown";
	if($data['gender']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Gender': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	
	if($data['city']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'City': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['mobile']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Mobile': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['product'] == '') $data['product'] = "Unknown";
	if($data['product']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Product': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['brand'] == '') $data['brand'] = "Unknown";
	if($data['brand']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Brand': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	
	/* for empty upload fields, when saving a copy of an existing record, copy the original upload field */
	if($_REQUEST['SelectedID']){
		$res = sql("select * from patners where id='" . makeSafe($_REQUEST['SelectedID']) . "'", $eo);
		if($row = db_fetch_assoc($res)){
			if(!$data['image']) $data['image'] = makeSafe($row['image']);
		}
	}

	// hook: patners_before_insert
	if(function_exists('patners_before_insert')){
		$args=array();
		if(!patners_before_insert($data, getMemberInfo(), $args)){ return false; }
	}

	$o = array('silentErrors' => true);
	sql('insert into `patners` set       `last_name`=' . (($data['last_name'] !== '' && $data['last_name'] !== NULL) ? "'{$data['last_name']}'" : 'NULL') . ', `first_name`=' . (($data['first_name'] !== '' && $data['first_name'] !== NULL) ? "'{$data['first_name']}'" : 'NULL') . ', `gender`=' . (($data['gender'] !== '' && $data['gender'] !== NULL) ? "'{$data['gender']}'" : 'NULL') . ', `birth_date`=' . (($data['birth_date'] !== '' && $data['birth_date'] !== NULL) ? "'{$data['birth_date']}'" : 'NULL') . ', ' . ($data['image'] != '' ? "`image`='{$data['image']}'" : '`image`=NULL') . ', `city`=' . (($data['city'] !== '' && $data['city'] !== NULL) ? "'{$data['city']}'" : 'NULL') . ', `mobile`=' . (($data['mobile'] !== '' && $data['mobile'] !== NULL) ? "'{$data['mobile']}'" : 'NULL') . ', `product`=' . (($data['product'] !== '' && $data['product'] !== NULL) ? "'{$data['product']}'" : 'NULL') . ', `brand`=' . (($data['brand'] !== '' && $data['brand'] !== NULL) ? "'{$data['brand']}'" : 'NULL') . ', `filed`=' . "'{$data['filed']}'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo "<a href=\"patners_view.php?addNew_x=1\">{$Translation['< back']}</a>";
		exit;
	}

	$recID = db_insert_id(db_link());

	// hook: patners_after_insert
	if(function_exists('patners_after_insert')){
		$res = sql("select * from `patners` where `id`='" . makeSafe($recID, false) . "' limit 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = makeSafe($recID, false);
		$args=array();
		if(!patners_after_insert($data, getMemberInfo(), $args)){ return $recID; }
	}

	// mm: save ownership data
	sql("insert ignore into membership_userrecords set tableName='patners', pkValue='" . makeSafe($recID, false) . "', memberID='" . makeSafe(getLoggedMemberID(), false) . "', dateAdded='" . time() . "', dateUpdated='" . time() . "', groupID='" . getLoggedGroupID() . "'", $eo);

	return $recID;
}

function patners_delete($selected_id, $AllowDeleteOfParents=false, $skipChecks=false){
	// insure referential integrity ...
	global $Translation;
	$selected_id=makeSafe($selected_id);

	// mm: can member delete record?
	$arrPerm=getTablePermissions('patners');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patners' and pkValue='$selected_id'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patners' and pkValue='$selected_id'");
	if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
		// delete allowed, so continue ...
	}else{
		return $Translation['You don\'t have enough permissions to delete this record'];
	}

	// hook: patners_before_delete
	if(function_exists('patners_before_delete')){
		$args=array();
		if(!patners_before_delete($selected_id, $skipChecks, getMemberInfo(), $args))
			return $Translation['Couldn\'t delete this record'];
	}

	// child table: medical_records
	$res = sql("select `id` from `patners` where `id`='$selected_id'", $eo);
	$id = db_fetch_row($res);
	$rires = sql("select count(1) from `medical_records` where `patient`='".addslashes($id[0])."'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "medical_records", $RetMsg);
		return $RetMsg;
	}elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["confirm delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "medical_records", $RetMsg);
		$RetMsg = str_replace("<Delete>", "<input type=\"button\" class=\"button\" value=\"".$Translation['yes']."\" onClick=\"window.location='patners_view.php?SelectedID=".urlencode($selected_id)."&delete_x=1&confirmed=1';\">", $RetMsg);
		$RetMsg = str_replace("<Cancel>", "<input type=\"button\" class=\"button\" value=\"".$Translation['no']."\" onClick=\"window.location='patners_view.php?SelectedID=".urlencode($selected_id)."';\">", $RetMsg);
		return $RetMsg;
	}

	// child table: events
	$res = sql("select `id` from `patners` where `id`='$selected_id'", $eo);
	$id = db_fetch_row($res);
	$rires = sql("select count(1) from `events` where `name_patient`='".addslashes($id[0])."'", $eo);
	$rirow = db_fetch_row($rires);
	if($rirow[0] && !$AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["couldn't delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "events", $RetMsg);
		return $RetMsg;
	}elseif($rirow[0] && $AllowDeleteOfParents && !$skipChecks){
		$RetMsg = $Translation["confirm delete"];
		$RetMsg = str_replace("<RelatedRecords>", $rirow[0], $RetMsg);
		$RetMsg = str_replace("<TableName>", "events", $RetMsg);
		$RetMsg = str_replace("<Delete>", "<input type=\"button\" class=\"button\" value=\"".$Translation['yes']."\" onClick=\"window.location='patners_view.php?SelectedID=".urlencode($selected_id)."&delete_x=1&confirmed=1';\">", $RetMsg);
		$RetMsg = str_replace("<Cancel>", "<input type=\"button\" class=\"button\" value=\"".$Translation['no']."\" onClick=\"window.location='patners_view.php?SelectedID=".urlencode($selected_id)."';\">", $RetMsg);
		return $RetMsg;
	}

	sql("delete from `patners` where `id`='$selected_id'", $eo);

	// hook: patners_after_delete
	if(function_exists('patners_after_delete')){
		$args=array();
		patners_after_delete($selected_id, getMemberInfo(), $args);
	}

	// mm: delete ownership data
	sql("delete from membership_userrecords where tableName='patners' and pkValue='$selected_id'", $eo);
}

function patners_update($selected_id){
	global $Translation;

	// mm: can member edit record?
	$arrPerm=getTablePermissions('patners');
	$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patners' and pkValue='".makeSafe($selected_id)."'");
	$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patners' and pkValue='".makeSafe($selected_id)."'");
	if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){ // allow update?
		// update allowed, so continue ...
	}else{
		return false;
	}

	$data['last_name'] = makeSafe($_REQUEST['last_name']);
		if($data['last_name'] == empty_lookup_value){ $data['last_name'] = ''; }
	$data['first_name'] = makeSafe($_REQUEST['first_name']);
		if($data['first_name'] == empty_lookup_value){ $data['first_name'] = ''; }
	$data['gender'] = makeSafe($_REQUEST['gender']);
		if($data['gender'] == empty_lookup_value){ $data['gender'] = ''; }
	$data['birth_date'] = intval($_REQUEST['birth_dateYear']) . '-' . intval($_REQUEST['birth_dateMonth']) . '-' . intval($_REQUEST['birth_dateDay']);
	$data['birth_date'] = parseMySQLDate($data['birth_date'], '');
	$data['city'] = makeSafe($_REQUEST['city']);
		if($data['city'] == empty_lookup_value){ $data['city'] = ''; }
	$data['mobile'] = makeSafe($_REQUEST['mobile']);
		if($data['mobile'] == empty_lookup_value){ $data['mobile'] = ''; }
	$data['product'] = makeSafe($_REQUEST['product']);
		if($data['product'] == empty_lookup_value){ $data['product'] = ''; }
	$data['brand'] = makeSafe($_REQUEST['brand']);
		if($data['brand'] == empty_lookup_value){ $data['brand'] = ''; }
	$data['last_modified'] = parseCode('<%%editingDateTime%%>', false, true);
	$data['selectedID']=makeSafe($selected_id);
	if($_REQUEST['image_remove'] == 1){
		$data['image'] = '';
	}else{
		$data['image'] = makeSafe($_REQUEST['image']);
			if($data['image'] == empty_lookup_value){ $data['image'] = ''; }
	}

	if($data['last_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Last name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['first_name']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'First name': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['gender'] == '') $data['gender'] = "Unknown";
	if($data['gender']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Gender': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	
	if($data['city']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'City': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['mobile']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Mobile': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['product'] == '') $data['product'] = "Unknown";
	if($data['product']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Product': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}
	if($data['brand'] == '') $data['brand'] = "Unknown";
	if($data['brand']== ''){
		echo StyleSheet() . "\n\n<div class=\"alert alert-danger\">" . $Translation['error:'] . " 'Brand': " . $Translation['field not null'] . '<br><br>';
		echo '<a href="" onclick="history.go(-1); return false;">'.$Translation['< back'].'</a></div>';
		exit;
	}

	// hook: patners_before_update
	if(function_exists('patners_before_update')){
		$args=array();
		if(!patners_before_update($data, getMemberInfo(), $args)){ return false; }
	}

	$o=array('silentErrors' => true);
	sql('update `patners` set       `last_name`=' . (($data['last_name'] !== '' && $data['last_name'] !== NULL) ? "'{$data['last_name']}'" : 'NULL') . ', `first_name`=' . (($data['first_name'] !== '' && $data['first_name'] !== NULL) ? "'{$data['first_name']}'" : 'NULL') . ', `gender`=' . (($data['gender'] !== '' && $data['gender'] !== NULL) ? "'{$data['gender']}'" : 'NULL') . ', `birth_date`=' . (($data['birth_date'] !== '' && $data['birth_date'] !== NULL) ? "'{$data['birth_date']}'" : 'NULL') . ', ' . ($data['image']!='' ? "`image`='{$data['image']}'" : ($_REQUEST['image_remove'] != 1 ? '`image`=`image`' : '`image`=NULL')) . ', `city`=' . (($data['city'] !== '' && $data['city'] !== NULL) ? "'{$data['city']}'" : 'NULL') . ', `mobile`=' . (($data['mobile'] !== '' && $data['mobile'] !== NULL) ? "'{$data['mobile']}'" : 'NULL') . ', `product`=' . (($data['product'] !== '' && $data['product'] !== NULL) ? "'{$data['product']}'" : 'NULL') . ', `brand`=' . (($data['brand'] !== '' && $data['brand'] !== NULL) ? "'{$data['brand']}'" : 'NULL') . ', `filed`=`filed`' . ', `last_modified`=' . "'{$data['last_modified']}'" . " where `id`='".makeSafe($selected_id)."'", $o);
	if($o['error']!=''){
		echo $o['error'];
		echo '<a href="patners_view.php?SelectedID='.urlencode($selected_id)."\">{$Translation['< back']}</a>";
		exit;
	}


	// hook: patners_after_update
	if(function_exists('patners_after_update')){
		$res = sql("SELECT * FROM `patners` WHERE `id`='{$data['selectedID']}' LIMIT 1", $eo);
		if($row = db_fetch_assoc($res)){
			$data = array_map('makeSafe', $row);
		}
		$data['selectedID'] = $data['id'];
		$args = array();
		if(!patners_after_update($data, getMemberInfo(), $args)){ return; }
	}

	// mm: update ownership data
	sql("update membership_userrecords set dateUpdated='".time()."' where tableName='patners' and pkValue='".makeSafe($selected_id)."'", $eo);

}

function patners_form($selected_id = '', $AllowUpdate = 1, $AllowInsert = 1, $AllowDelete = 1, $ShowCancel = 0, $TemplateDV = '', $TemplateDVP = ''){
	// function to return an editable form for a table records
	// and fill it with data of record whose ID is $selected_id. If $selected_id
	// is empty, an empty form is shown, with only an 'Add New'
	// button displayed.

	global $Translation;

	// mm: get table permissions
	$arrPerm=getTablePermissions('patners');
	if(!$arrPerm[1] && $selected_id==''){ return ''; }
	$AllowInsert = ($arrPerm[1] ? true : false);
	// print preview?
	$dvprint = false;
	if($selected_id && $_REQUEST['dvprint_x'] != ''){
		$dvprint = true;
	}


	// populate filterers, starting from children to grand-parents

	// unique random identifier
	$rnd1 = ($dvprint ? rand(1000000, 9999999) : '');
	// combobox: gender
	$combo_gender = new Combo;
	$combo_gender->ListType = 0;
	$combo_gender->MultipleSeparator = ', ';
	$combo_gender->ListBoxHeight = 10;
	$combo_gender->RadiosPerLine = 1;
	if(is_file(dirname(__FILE__).'/hooks/patners.gender.csv')){
		$gender_data = addslashes(implode('', @file(dirname(__FILE__).'/hooks/patners.gender.csv')));
		$combo_gender->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions($gender_data)));
		$combo_gender->ListData = $combo_gender->ListItem;
	}else{
		$combo_gender->ListItem = explode('||', entitiesToUTF8(convertLegacyOptions("Unknown;;Male;;Female;;Other")));
		$combo_gender->ListData = $combo_gender->ListItem;
	}
	$combo_gender->SelectName = 'gender';
	$combo_gender->AllowNull = false;
	
	// combobox: birth_date
	$combo_birth_date = new DateCombo;
	$combo_birth_date->DateFormat = "mdy";
	$combo_birth_date->MinYear = 1900;
	$combo_birth_date->MaxYear = 2100;
	$combo_birth_date->DefaultDate = parseMySQLDate('', '');
	$combo_birth_date->MonthNames = $Translation['month names'];
	$combo_birth_date->NamePrefix = 'birth_date';
	

	if($selected_id){
		// mm: check member permissions
		if(!$arrPerm[2]){
			return "";
		}
		// mm: who is the owner?
		$ownerGroupID=sqlValue("select groupID from membership_userrecords where tableName='patners' and pkValue='".makeSafe($selected_id)."'");
		$ownerMemberID=sqlValue("select lcase(memberID) from membership_userrecords where tableName='patners' and pkValue='".makeSafe($selected_id)."'");
		if($arrPerm[2]==1 && getLoggedMemberID()!=$ownerMemberID){
			return "";
		}
		if($arrPerm[2]==2 && getLoggedGroupID()!=$ownerGroupID){
			return "";
		}

		// can edit?
		if(($arrPerm[3]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[3]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[3]==3){
			$AllowUpdate=1;
		}else{
			$AllowUpdate=0;
		}

		$res = sql("select * from `patners` where `id`='".makeSafe($selected_id)."'", $eo);
		if(!($row = db_fetch_array($res))){
			return error_message($Translation['No records found'], 'patners_view.php', false);
		}
		$urow = $row; /* unsanitized data */
		$hc = new CI_Input();
		$row = $hc->xss_clean($row); /* sanitize data */
		$combo_gender->SelectedData = $row['gender'];
		$combo_birth_date->DefaultDate = $row['birth_date'];
		$row['filed'] = sqlValue("select DATE_FORMAT(`filed`, '%c/%e/%Y %l:%i%p') from `patners` where `id`='".makeSafe($selected_id)."'");
		$row['last_modified'] = sqlValue("select DATE_FORMAT(`last_modified`, '%c/%e/%Y %l:%i%p') from `patners` where `id`='".makeSafe($selected_id)."'");
	}else{
		$combo_gender->SelectedText = ( $_REQUEST['FilterField'][1]=='4' && $_REQUEST['FilterOperator'][1]=='<=>' ? (get_magic_quotes_gpc() ? stripslashes($_REQUEST['FilterValue'][1]) : $_REQUEST['FilterValue'][1]) : "Unknown");
	}
	$combo_gender->Render();

	// code for template based detail view forms

	// open the detail view template
	if($dvprint){
		$template_file = is_file("./{$TemplateDVP}") ? "./{$TemplateDVP}" : './templates/patners_templateDVP.html';
		$templateCode = @file_get_contents($template_file);
	}else{
		$template_file = is_file("./{$TemplateDV}") ? "./{$TemplateDV}" : './templates/patners_templateDV.html';
		$templateCode = @file_get_contents($template_file);
	}

	// process form title
	$templateCode = str_replace('<%%DETAIL_VIEW_TITLE%%>', 'Patient details', $templateCode);
	$templateCode = str_replace('<%%RND1%%>', $rnd1, $templateCode);
	$templateCode = str_replace('<%%EMBEDDED%%>', ($_REQUEST['Embedded'] ? 'Embedded=1' : ''), $templateCode);
	// process buttons
	if($arrPerm[1] && !$selected_id){ // allow insert and no record selected?
		if(!$selected_id) $templateCode=str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-success" id="insert" name="insert_x" value="1" onclick="return patners_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save New'] . '</button>', $templateCode);
		$templateCode=str_replace('<%%INSERT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="insert" name="insert_x" value="1" onclick="return patners_validateData();"><i class="glyphicon glyphicon-plus-sign"></i> ' . $Translation['Save As Copy'] . '</button>', $templateCode);
	}else{
		$templateCode=str_replace('<%%INSERT_BUTTON%%>', '', $templateCode);
	}

	// 'Back' button action
	if($_REQUEST['Embedded']){
		$backAction = 'window.parent.jQuery(\'.modal\').modal(\'hide\'); return false;';
	}else{
		$backAction = '$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;';
	}

	if($selected_id){
		if(!$_REQUEST['Embedded']) $templateCode=str_replace('<%%DVPRINT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="dvprint" name="dvprint_x" value="1" onclick="$$(\'form\')[0].writeAttribute(\'novalidate\', \'novalidate\'); document.myform.reset(); return true;" title="' . html_attr($Translation['Print Preview']) . '"><i class="glyphicon glyphicon-print"></i> ' . $Translation['Print Preview'] . '</button>', $templateCode);
		if($AllowUpdate){
			$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '<button type="submit" class="btn btn-success btn-lg" id="update" name="update_x" value="1" onclick="return patners_validateData();" title="' . html_attr($Translation['Save Changes']) . '"><i class="glyphicon glyphicon-ok"></i> ' . $Translation['Save Changes'] . '</button>', $templateCode);
		}else{
			$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		}
		if(($arrPerm[4]==1 && $ownerMemberID==getLoggedMemberID()) || ($arrPerm[4]==2 && $ownerGroupID==getLoggedGroupID()) || $arrPerm[4]==3){ // allow delete?
			$templateCode=str_replace('<%%DELETE_BUTTON%%>', '<button type="submit" class="btn btn-danger" id="delete" name="delete_x" value="1" onclick="return confirm(\'' . $Translation['are you sure?'] . '\');" title="' . html_attr($Translation['Delete']) . '"><i class="glyphicon glyphicon-trash"></i> ' . $Translation['Delete'] . '</button>', $templateCode);
		}else{
			$templateCode=str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		}
		$templateCode=str_replace('<%%DESELECT_BUTTON%%>', '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>', $templateCode);
	}else{
		$templateCode=str_replace('<%%UPDATE_BUTTON%%>', '', $templateCode);
		$templateCode=str_replace('<%%DELETE_BUTTON%%>', '', $templateCode);
		$templateCode=str_replace('<%%DESELECT_BUTTON%%>', ($ShowCancel ? '<button type="submit" class="btn btn-default" id="deselect" name="deselect_x" value="1" onclick="' . $backAction . '" title="' . html_attr($Translation['Back']) . '"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['Back'] . '</button>' : ''), $templateCode);
	}

	// set records to read only if user can't insert new records and can't edit current record
	if(($selected_id && !$AllowUpdate) || (!$selected_id && !$AllowInsert)){
		$jsReadOnly .= "\tjQuery('#last_name').replaceWith('<div class=\"form-control-static\" id=\"last_name\">' + (jQuery('#last_name').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#first_name').replaceWith('<div class=\"form-control-static\" id=\"first_name\">' + (jQuery('#first_name').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#gender').replaceWith('<div class=\"form-control-static\" id=\"gender\">' + (jQuery('#gender').val() || '') + '</div>'); jQuery('#gender-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#birth_date').prop('readonly', true);\n";
		$jsReadOnly .= "\tjQuery('#birth_dateDay, #birth_dateMonth, #birth_dateYear').prop('disabled', true).css({ color: '#555', backgroundColor: '#fff' });\n";
		$jsReadOnly .= "\tjQuery('#image').replaceWith('<div class=\"form-control-static\" id=\"image\">' + (jQuery('#image').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#city').replaceWith('<div class=\"form-control-static\" id=\"city\">' + (jQuery('#city').val() || '') + '</div>'); jQuery('#city-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#mobile').replaceWith('<div class=\"form-control-static\" id=\"mobile\">' + (jQuery('#mobile').val() || '') + '</div>');\n";
		$jsReadOnly .= "\tjQuery('#product').replaceWith('<div class=\"form-control-static\" id=\"product\">' + (jQuery('#product').val() || '') + '</div>'); jQuery('#product-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('#brand').replaceWith('<div class=\"form-control-static\" id=\"brand\">' + (jQuery('#brand').val() || '') + '</div>'); jQuery('#brand-multi-selection-help').hide();\n";
		$jsReadOnly .= "\tjQuery('.select2-container').hide();\n";

		$noUploads = true;
	}elseif(($AllowInsert && !$selected_id) || ($AllowUpdate && $selected_id)){
		$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', true);"; // temporarily disable form change handler
			$jsEditable .= "\tjQuery('form').eq(0).data('already_changed', false);"; // re-enable form change handler
	}

	// process combos
	$templateCode=str_replace('<%%COMBO(gender)%%>', $combo_gender->HTML, $templateCode);
	$templateCode=str_replace('<%%COMBOTEXT(gender)%%>', $combo_gender->SelectedData, $templateCode);
	$templateCode=str_replace('<%%COMBO(birth_date)%%>', ($selected_id && !$arrPerm[3] ? '<div class="form-control-static">' . $combo_birth_date->GetHTML(true) . '</div>' : $combo_birth_date->GetHTML()), $templateCode);
	$templateCode=str_replace('<%%COMBOTEXT(birth_date)%%>', $combo_birth_date->GetHTML(true), $templateCode);

	/* lookup fields array: 'lookup field name' => array('parent table name', 'lookup field caption') */
	$lookup_fields = array();
	foreach($lookup_fields as $luf => $ptfc){
		$pt_perm = getTablePermissions($ptfc[0]);

		// process foreign key links
		if($pt_perm['view'] || $pt_perm['edit']){
			$templateCode = str_replace("<%%PLINK({$luf})%%>", '<button type="button" class="btn btn-default view_parent hspacer-md" id="' . $ptfc[0] . '_view_parent" title="' . html_attr($Translation['View'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-eye-open"></i></button>', $templateCode);
		}

		// if user has insert permission to parent table of a lookup field, put an add new button
		if($pt_perm['insert'] && !$_REQUEST['Embedded']){
			$templateCode = str_replace("<%%ADDNEW({$ptfc[0]})%%>", '<button type="button" class="btn btn-success add_new_parent hspacer-md" id="' . $ptfc[0] . '_add_new" title="' . html_attr($Translation['Add New'] . ' ' . $ptfc[1]) . '"><i class="glyphicon glyphicon-plus-sign"></i></button>', $templateCode);
		}
	}

	// process images
	$templateCode=str_replace('<%%UPLOADFILE(id)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(last_name)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(first_name)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(gender)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(birth_date)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(age)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(image)%%>', ($noUploads ? '' : '<input type=hidden name=MAX_FILE_SIZE value=1024000>'.$Translation['upload image'].' <input type="file" name="image" id="image">'), $templateCode);
	if($AllowUpdate && $row['image']!=''){
		$templateCode=str_replace('<%%REMOVEFILE(image)%%>', '<br><input type="checkbox" name="image_remove" id="image_remove" value="1"> <label for="image_remove" style="color: red; font-weight: bold;">'.$Translation['remove image'].'</label>', $templateCode);
	}else{
		$templateCode=str_replace('<%%REMOVEFILE(image)%%>', '', $templateCode);
	}
	$templateCode=str_replace('<%%UPLOADFILE(city)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(mobile)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(product)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(brand)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(filed)%%>', '', $templateCode);
	$templateCode=str_replace('<%%UPLOADFILE(last_modified)%%>', '', $templateCode);

	// process values
	if($selected_id){
		$templateCode=str_replace('<%%VALUE(id)%%>', html_attr($row['id']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(id)%%>', urlencode($urow['id']), $templateCode);
		$templateCode=str_replace('<%%VALUE(last_name)%%>', html_attr($row['last_name']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(last_name)%%>', urlencode($urow['last_name']), $templateCode);
		$templateCode=str_replace('<%%VALUE(first_name)%%>', html_attr($row['first_name']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(first_name)%%>', urlencode($urow['first_name']), $templateCode);
		$templateCode=str_replace('<%%VALUE(gender)%%>', html_attr($row['gender']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(gender)%%>', urlencode($urow['gender']), $templateCode);
		$templateCode=str_replace('<%%VALUE(birth_date)%%>', @date('m/d/Y', @strtotime(html_attr($row['birth_date']))), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(birth_date)%%>', urlencode(@date('m/d/Y', @strtotime(html_attr($urow['birth_date'])))), $templateCode);
		$templateCode=str_replace('<%%VALUE(age)%%>', html_attr($row['age']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(age)%%>', urlencode($urow['age']), $templateCode);
		$row['image']= "http://". getenv("HTTP_HOST") . "/treestate/images/". sqlValue("select `image` from `patners` where `id`='".makeSafe($selected_id)."'");
		$templateCode=str_replace('<%%VALUE(image)%%>', html_attr($row['image']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(image)%%>', urlencode($urow['image']), $templateCode);
		$templateCode=str_replace('<%%VALUE(city)%%>', html_attr($row['city']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(city)%%>', urlencode($urow['city']), $templateCode);
		$templateCode=str_replace('<%%VALUE(mobile)%%>', html_attr($row['mobile']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(mobile)%%>', urlencode($urow['mobile']), $templateCode);
		$templateCode=str_replace('<%%VALUE(product)%%>', html_attr($row['product']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(product)%%>', urlencode($urow['product']), $templateCode);
		$templateCode=str_replace('<%%VALUE(brand)%%>', html_attr($row['brand']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(brand)%%>', urlencode($urow['brand']), $templateCode);
		$templateCode=str_replace('<%%VALUE(filed)%%>', html_attr($row['filed']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(filed)%%>', urlencode($urow['filed']), $templateCode);
		$templateCode=str_replace('<%%VALUE(last_modified)%%>', html_attr($row['last_modified']), $templateCode);
		$templateCode=str_replace('<%%URLVALUE(last_modified)%%>', urlencode($urow['last_modified']), $templateCode);
	}else{
		$templateCode=str_replace('<%%VALUE(id)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(id)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(last_name)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(last_name)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(first_name)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(first_name)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(gender)%%>', 'Unknown', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(gender)%%>', urlencode('Unknown'), $templateCode);
		$templateCode=str_replace('<%%VALUE(birth_date)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(birth_date)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(age)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(age)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(image)%%>', 'blank.gif', $templateCode);
		$templateCode=str_replace('<%%VALUE(city)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(city)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(mobile)%%>', '', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(mobile)%%>', urlencode(''), $templateCode);
		$templateCode=str_replace('<%%VALUE(product)%%>', 'Unknown', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(product)%%>', urlencode('Unknown'), $templateCode);
		$templateCode=str_replace('<%%VALUE(brand)%%>', 'Unknown', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(brand)%%>', urlencode('Unknown'), $templateCode);
		$templateCode=str_replace('<%%VALUE(filed)%%>', '<%%creationDateTime%%>', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(filed)%%>', urlencode('<%%creationDateTime%%>'), $templateCode);
		$templateCode=str_replace('<%%VALUE(last_modified)%%>', '<%%editingDateTime%%>', $templateCode);
		$templateCode=str_replace('<%%URLVALUE(last_modified)%%>', urlencode('<%%editingDateTime%%>'), $templateCode);
	}

	// process translations
	foreach($Translation as $symbol=>$trans){
		$templateCode=str_replace("<%%TRANSLATION($symbol)%%>", $trans, $templateCode);
	}

	// clear scrap
	$templateCode=str_replace('<%%', '<!-- ', $templateCode);
	$templateCode=str_replace('%%>', ' -->', $templateCode);

	// hide links to inaccessible tables
	if($_REQUEST['dvprint_x'] == ''){
		$templateCode .= "\n\n<script>\$j(function(){\n";
		$arrTables = getTableList();
		foreach($arrTables as $name => $caption){
			$templateCode .= "\t\$j('#{$name}_link').removeClass('hidden');\n";
			$templateCode .= "\t\$j('#xs_{$name}_link').removeClass('hidden');\n";
		}

		$templateCode .= $jsReadOnly;
		$templateCode .= $jsEditable;

		if(!$selected_id){
		}

		$templateCode.="\n});</script>\n";
	}

	// ajaxed auto-fill fields
	$templateCode .= '<script>';
	$templateCode .= '$j(function() {';


	$templateCode.="});";
	$templateCode.="</script>";
	$templateCode .= $lookups;

	// handle enforced parent values for read-only lookup fields

	// don't include blank images in lightbox gallery
	$templateCode = preg_replace('/blank.gif" data-lightbox=".*?"/', 'blank.gif"', $templateCode);

	// don't display empty email links
	$templateCode=preg_replace('/<a .*?href="mailto:".*?<\/a>/', '', $templateCode);

	/* default field values */
	$rdata = $jdata = get_defaults('patners');
	if($selected_id){
		$jdata = get_joined_record('patners', $selected_id);
		$rdata = $row;
	}
	$cache_data = array(
		'rdata' => array_map('nl2br', array_map('addslashes', $rdata)),
		'jdata' => array_map('nl2br', array_map('addslashes', $jdata)),
	);
	$templateCode .= loadView('patners-ajax-cache', $cache_data);

	// hook: patners_dv
	if(function_exists('patners_dv')){
		$args=array();
		patners_dv(($selected_id ? $selected_id : FALSE), getMemberInfo(), $templateCode, $args);
	}

	return $templateCode;
}
?>