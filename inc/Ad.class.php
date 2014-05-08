<?php
# Name: Database.class.php
# File Description: Class to hold and manage ads
# Author: Philipp Sendek
# Date: 02.04.2010
/*
function __autoload($class_name){
	require dirname(__FILE__)."/inc/".$class_name.".class.php";
}
*/

class Ad {
	
	private $id;
	private $name;
	private $start_date;
	private $end_date;
	private $image_url;
	private $link_url;
	private $categoryid;
	private $postcode;
	private $city;
	private $display_position;
	private $times_shown;
	private $description;
	private $timestamp;

	private static $table = "tbl_ads";
	public static $kat_table = "markt_inserate_kats"; 


	public function Ad($name = "", $start_date = "", $end_date = "", $image_url = "", $link_url = "", $categoryid = "", $postcode = "", $city = "", $display_position = "", $times_shown = "0", $description = ""){

		$this->name = $name;
		$this->start_date = self::ReformatDate($start_date);
		$this->end_date = self::ReformatDate($end_date);
		$this->image_url = $image_url;
		$this->link_url = $link_url;
		$this->categoryid = $categoryid;
		$this->postcode = $postcode;
		$this->city = $city;
		$this->display_position = $display_position;
		$this->times_shown = $times_shown;
		$this->description = $description;

	} 

	public function __tostring(){
		return "Infotext hier";
	}

	public function __get($key){
		if(isset($this->$key)){
			return $this->$key;
		}
	}

	public function __set($key, $val){
		if(isset($this->$key)){
			if ($key == "start_date" || $key == "end_date"){
				$this->$key = ReformatDate($val);
			}
			else {
				$this->$key = $val;
			}			
		}	
	}

	public function setId($id){
		$this->id = $id;
	}
	
	public static function ReformatDate($date){
		
		if(strstr($date, '.') === FALSE)
		{
			return $date; 
		}
		else {
			$arDate = explode('.', $date);
			$newDate = $arDate[2]."-".$arDate[1]."-".$arDate[0];
			return $newDate;
		}
	}
	
	public function GetDataArray(){
	
		$data = array("name" => $this->name, 
				  	  "start_date" => $this->start_date,
				  	  "end_date" => $this->end_date,
					  "image_url" => $this->image_url,
					  "link_url" => $this->link_url,
					  "categoryid" => $this->categoryid,
					  "postcode" => $this->postcode,
					  "city" => $this->city,
					  "display_position" => $this->display_position,
					  "times_shown" => $this->times_shown,
					  "description" => $this->description);
		return $data;
	
	}

	public function GetTimestamp(){
		
		$db = new Database();
		$db->connect();
		$out = $db->query("SELECT timestamp FROM ".self::$table." WHERE id = '".$this->id."'");
		return $out;
		
	}
	
	public function LoadFromDB($id){
	
		$db = new Database();
		$db->connect();
		$out = $db->query_first_object(self::$table, $id);
		$db->close();
		
		$this->Ad($out['name'], $out['start_date'], $out['end_date'], $out['image_url'], $out['link_url'], $out['categoryid'], $out['postcode'], $out['city'], $out['display_position'], $out['times_shown'], $out['description']);
		$this->id = $out['id'];
		$this->timestamp = $out['timestamp'];
		
	}

	public function InsertInDB(){
	
		$data = $this->GetDataArray();
		$db = new Database();
		$db->connect();
		$out = $db->query_insert(self::$table, $data);
		$db->close();
		return $out;
	
	}

	public function SaveToDB(){
	
		$data = $this->GetDataArray();
		$db = new Database();
		$db->connect();
		$out = $db->query_update(self::$table, $data, 'id = '.$this->id);
		$db->close();
		return $out;
	
	}
	
	public function DeleteAd(){
		
		$db = new Database();
		$db->connect();
		$out = $db->query_delete(self::$table, 'id = '.$this->id);
		$db->close();
		return $out;
		
	}
	
	#-#############################################
	# desc: returns all ad-objects in an object-container
	# param: none
	# returns: SplObjectStorage object with all Ad-objects	
	public static function LoadAllFromDB(){
		
		$db = new Database();
		$db->connect();
		$out = $db->fetch_all_array("SELECT * FROM `".self::$table."`"); // Out beinhaltet alle Einträge der Datenbank als Array
		$db->close();
		
		//print_r($out);
		//echo count($out);
		
		$adStore = new SplObjectStorage(); // Neues Container-Objekt
		
		foreach($out as $singleAd){
			
			$adObj = new Ad($singleAd['name'], $singleAd['start_date'], $singleAd['end_date'], $singleAd['image_url'], $singleAd['link_url'], $singleAd['categoryid'], $singleAd['postcode'], $singleAd['city'], $singleAd['display_position'], $singleAd['times_shown'], $singleAd['description']);
			$adObj->id = $singleAd['id']; // id wird im Construktor (das Ding eine Zeile höher) nicht berücksichtigt, da es sonst immer ein "muss" Wert ist - somit wird sie hier nachträglich gesetzt
			$adObj->timestamp = $singleAd['timestamp']; // Ebenso der Timestamp
			
			$adStore->attach($adObj); // Füge $adObj dem Container hinzu
			
			unset($adObj);
			
		}
		
		return $adStore;
		
		//echo $adStore->count();
		//$this->Ad($out['name'], $out['start_date'], $out['end_date'], $out['image_url'], $out['link_url'], $out['categoryid'], $out['postcode'], $out['description']);
		//$this->id = $out['id'];
		//$this->timestamp = $out['timestamp'];
		
	}
	
	#-#############################################
	# desc: returns all ad-objects in an object-container filtered by postcode/city/category
	# param: none
	# returns: SplObjectStorage object with all Ad-objects	
	public static function ServeAds($postcode = "", $city = "", $categoryid = "", $where = ""){
		
		if ($city != ""){
			$where = "AND `city`='".$city."'";
			if($categoryid != ""){
				$where = " AND `categoryid`='".$categoryid."'";
			}
		}
		if ($postcode != ""){
			if(strlen($postcode) < 5){
				$where = "AND `postcode` LIKE '".$postcode."%'";
			}
			else {
				$where = "AND `postcode`='".$postcode."'";
			}
			if($categoryid != ""){
				$where .= " AND `categoryid`='".$categoryid."'";
			}
		}
		if($categoryid != ""){
				$where .= " AND `categoryid`='".$categoryid."'";
		}
		
		$db = new Database();
		$db->connect();
		$out = $db->fetch_all_array("SELECT * FROM `".self::$table."` WHERE start_date <= CURDATE() AND end_date >= CURDATE() ".$where." ORDER BY display_position ASC"); // Out beinhaltet alle Einträge der Datenbank als Array
		$db->close();
				
		$adStore = new SplObjectStorage(); // Neues Container-Objekt
		
		foreach($out as $singleAd){
			
			$adObj = new Ad($singleAd['name'], $singleAd['start_date'], $singleAd['end_date'], $singleAd['image_url'], $singleAd['link_url'], $singleAd['categoryid'], $singleAd['postcode'], $singleAd['city'], $singleAd['display_position'], $singleAd['times_shown'], $singleAd['description']);
			$adObj->id = $singleAd['id']; // id wird im Construktor (das Ding eine Zeile höher) nicht berücksichtigt, da es sonst immer ein "muss" Wert ist - somit wird sie hier nachträglich gesetzt
			$adObj->timestamp = $singleAd['timestamp']; // Ebenso der Timestamp
			
			$adStore->attach($adObj); // Füge $adObj dem Container hinzu
			
			unset($adObj);
			
		}
		
		return $adStore;
		
	}
	
	public function PrintAd($debug = "0"){
 
		if($debug == "0"){
			$db = new Database();
			$db->connect();
			$out = $db->query("UPDATE `".self::$table."` SET times_shown = times_shown + 1 WHERE id = ".$this->id);
			$db->close();
		}
		
		return '<a href="'.$this->link_url.'" target="_blank"><img src="'.$this->image_url.'" style="width: 200px; height: 100px;border: 10px; margin-bottom: 20px; "></a>';
	
	}
		
}
?>