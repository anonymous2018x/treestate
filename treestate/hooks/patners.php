<?php
	// For help on using hooks, please refer to http://bigprof.com/appgini/help/working-with-generated-web-database-application/hooks

	function patners_init(&$options, $memberInfo, &$args){

		if(isset($_REQUEST['SelectedID'])){
			$id = makeSafe($_REQUEST['SelectedID']);
			$today = date('Y-m-d');
			
			sql("update patners set age=floor(datediff('{$today}', birth_date) / 365.25) where id='{$id}'", $eo);
		}
		return TRUE;
	}

	function patners_header($contentType, $memberInfo, &$args){
		$header='';

		switch($contentType){
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	function patners_footer($contentType, $memberInfo, &$args){
		$footer='';

		switch($contentType){
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	function patners_before_insert(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function patners_after_insert($data, $memberInfo, &$args){

		return TRUE;
	}

	function patners_before_update(&$data, $memberInfo, &$args){

		return TRUE;
	}

	function patners_after_update($data, $memberInfo, &$args){

		return TRUE;
	}

	function patners_before_delete($selectedID, &$skipChecks, $memberInfo, &$args){

		return TRUE;
	}

	function patners_after_delete($selectedID, $memberInfo, &$args){

	}

	function patners_dv($selectedID, $memberInfo, &$html, &$args){
       

	}

	function patners_csv($query, $memberInfo, &$args){

		return $query;
	}
	function patners_batch_actions(&$args){

		return array();
	}
