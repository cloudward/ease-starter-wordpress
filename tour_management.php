<?php
global $ease_core;

if(isset($_GET['tourPage'])){

	$sql = "SELECT * FROM tour_globals JOIN tour_locals ON tour_globals.uuid = tour_locals.parent_id WHERE tour_globals.tourPage=:tourPage";
	$params = array(':tourPage'=>$_GET['tourPage']);
	$query = $ease_core->db->prepare($sql);
	$result = $query->execute($params);
	$holderArray = array();
	while($row = ease_db_fetch($result)){
		$holderArray[] = $row;
	}
	
	$json = json_encode($holderArray, JSON_FORCE_OBJECT);

	/** Output Response **/
	echo $_GET['callback'] . '(' . $json . ')';
}
if(isset($_GET['action']) && $_GET['action'] == "deleteTour"){
	$sql = "DELETE FROM tour_locals WHERE parent_id=:uuid";
	$params = array(':uuid'=>$_GET['uuid']);
	$query = $ease_core->db->prepare($sql);
	$result = $query->execute($params);
	
	$sql = "DELETE FROM tour_globals WHERE uuid=:uuid";
	$params = array(':uuid'=>$_GET['uuid']);
	$query = $ease_core->db->prepare($sql);
	$result = $query->execute($params);
	$holderArray = array();
	if($result){
		$holderArray['result'] = "Success";
	}
	
	$json = json_encode($holderArray, JSON_FORCE_OBJECT);

	/** Output Response **/
	echo $_GET['callback'] . '(' . $json . ')';
}

if(isset($_GET['action']) && $_GET['action'] == "deleteStop"){
	$sql = "DELETE FROM tour_locals WHERE uuid=:uuid";
	$params = array(':uuid'=>$_GET['uuid']);
	$query = $ease_core->db->prepare($sql);
	$result = $query->execute($params);

	$holderArray = array();
	if($result){
		$holderArray['result'] = "Success";
	}
	
	$json = json_encode($holderArray, JSON_FORCE_OBJECT);

	/** Output Response **/
	echo $_GET['callback'] . '(' . $json . ')';
}

if(isset($_GET['action']) && $_GET['action'] == "addStop"){
	$uuid = uniqid();
	$sql = "INSERT INTO tour_locals (uuid, id, parent_id) VALUES (:uuid, :id, :parent_id);";
	$params = array(':uuid'=>$uuid, ':id'=>$uuid, ':parent_id'=>$_GET['parent_uuid']);
	$query = $ease_core->db->prepare($sql);
	$result = $query->execute($params);

	$holderArray = array();
	if($result){
		$holderArray['result'] = "Success";
		$holderArray['uuid'] = $uuid;
	}
	
	$json = json_encode($holderArray, JSON_FORCE_OBJECT);

	/** Output Response **/
	echo $_GET['callback'] . '(' . $json . ')';
}

?>