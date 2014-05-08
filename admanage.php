<html>
<head>
<title>AdServer-Administration</title>
<script language='JavaScript' type='text/javascript' src='./js/tabs.js'></script>
<script language='JavaScript' type='text/javascript' src='./js/prototype.js'></script>
<script language='JavaScript' type='text/javascript' src='./js/scriptaculous.js'></script>
<script type="text/javascript" src="./js/datepickercontrol.js"></script>
<script type="text/javascript" src="./js/funcs.js"></script>
<link type="text/css" rel="stylesheet" href="./css/datepickercontrol.css">
<link type="text/css" rel="stylesheet" href="./css/default.css">
</head>
<body>
<?php
//require("engine.php");
function __autoload($class_name){
	require dirname(__FILE__)."/inc/".$class_name.".class.php";
}

$site = $_GET['site'];

if ($site == "showAddForm" || $site == "editAd"){
	
	$form_action = $PHP_SELF."?site=processAdd";
	
	if ( $site == "editAd" && $_GET['aid'] != "" ){
		$aid = $_GET['aid'];
	
		$newAd = new Ad();
		$newAd->LoadFromDB($aid);
	
		$form_action = $PHP_SELF."?site=processEdit";
	}
	
?>
<form action="<?php echo $form_action; ?>" method="post">
            <table style="padding: 2px; margin: 0px auto; width: 70%">
						
				<input type="hidden" id="DPC_TODAY_TEXT" value="heute">
				<input type="hidden" id="DPC_BUTTON_TITLE" value="Kalender öffnen...">
				<input type="hidden" id="DPC_MONTH_NAMES" value="['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember']">
				<input type="hidden" id="DPC_DAY_NAMES" value="['So', 'Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa']"> 
	           	
	           	<input type="hidden" name="aid" value="<?php echo $newAd->id; ?>" />
	           	<input type="hidden" name="times_shown" value="<?php echo $newAd->times_shown; ?>" />
	           	
	           	<tr>
            		<td style="width: 300px">
            			Name
            		</td>
            		<td>
            			<input type="text" name="name" value="<?php echo $newAd->name; ?>" style="width: 300px" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Werbungs-Start
            		</td>
            		<td>
            			<input type="text" name="start_date" id="start_date" value="<?php if ($newAd->start_date != "") echo date('d.m.Y', strtotime( $newAd->start_date )); ?>" datepicker="true" datepicker_format="DD.MM.YYYY" style="width: 120px" />
            		</td>            		
            	</tr>
            	<tr>
            		<td>
            			Werbungs-Ende
            		</td>
            		<td>
            			<input type="text" name="end_date" id="end_date" value="<?php if ($newAd->end_date != "") echo date('d.m.Y', strtotime( $newAd->end_date )); ?>" datepicker="true" datepicker_format="DD.MM.YYYY" style="width: 120px" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Bild-Adresse
            		</td>
            		<td>
            			<input type="text" name="image_url" id="image_url" value="<?php echo $newAd->image_url; ?>" style="width: 300px" />&nbsp;<input type="button" value="Platzhalter" onclick="javascript:setPlaceholderAd('image_url');" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Link-Adresse
            		</td>
            		<td>
            			<input type="text" name="link_url" id="link_url" value="<?php echo $newAd->link_url; ?>" style="width: 300px" />&nbsp;<input type="button" value="Platzhalter" onclick="javascript:setPlaceholderLink('link_url');" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Kategorie
            		</td>
            		<td>
            			<select name="categoryid" style="width: 300px">
            			<?php 
            				$db = new Database();
            				$db->connect();
            				$out = $db->fetch_all_array("SELECT * FROM `".Ad::$kat_table."`");
            			
            				foreach($out as $category){

            					$pre = "";
            					$selected = "";
            					
            					if($category['sub'] != "0"){
            						$pre = "- ";
            					}

            					if ($category['id'] == $newAd->categoryid){
            						$selected = 'selected="selected"';
            					}
            					           						
            					echo '<option value="'.$category['id'].'" '.$selected.'>'.$pre.$category['kat'].'</option>';
            				            					
            				}
            			?> 
	            		</select>
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Postleitzahl<br />
            			<span style="font-size: 8pt">(Auch Teilangaben möglich (Bspw. 65))</span>
            		</td>
            		<td>
            			<input type="text" name="postcode" value="<?php echo $newAd->postcode; ?>" maxlength="5" style="width: 80px" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Stadt<br />
            		</td>
            		<td>
            			<input type="text" name="city" value="<?php echo $newAd->city; ?>" style="width: 300px" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Laufbandposition<br />
            			<span style="font-size: 8px">(1-10)</span>
            		</td>
            		<td>
            			<select name="display_position" style="width: 300px" >
            				<?php 
            				
            				for($i=1; $i <= 10; $i++){
            					
            					$text = "";
            					$selected = "";
            					
            					if($i == "1"){
            						$text = " - oben";
            					}
            					elseif ($i == "10"){
            						$text = " - unten";
            					}	
            					
            					if($i == $newAd->display_position){
            						$selected = 'selected="selected"';
            					}
            					
            					echo '<option value="'.$i.'" '.$selected.'>'.$i.$text.'</option>';
            				}
            				
            				?>
            			</select>
            		</td>
            	</tr>
            	<tr>
            		<td>
            			Kurzbeschreibung<br />
            			<span style="font-size: 8pt">(Maximal 250 Zeichen)</span>
            		</td>
            		<td>
            			<input type="text" name="description" value="<?php echo $newAd->description; ?>" maxlength="250" style="width: 300px" />
            		</td>
            	</tr>
            	<tr>
            		<td>
            		</td>
            		<td style="text-align: center">
            			<?php 
            			if ($site == "showAddForm" ){
            				$text = "Hinzufügen";
            			}	
            			elseif($site == "editAd"){
            				$text = "Speichern";
            			}
            			?>
            			
            			<input type="submit" value="<?php echo $text; ?>" style="margin-top: 20px"/>
            			
            		</td>
            	</tr>            
            </table>
            </form>
<?php 
}
elseif ($site == "showAllAds"){
	
	$adStorage = new SplObjectStorage();
	$adStorage = Ad::LoadAllFromDB();
	$adStorage->rewind();
?>
		<table cellpadding="5" cellspacing="0" style="margin: auto">
			<tr>
				<th id="adlist_th">
					#
				</th>
				<th id="adlist_th">
					Name
				</th>
				<th id="adlist_th">
					Start
				</th>
				<th id="adlist_th">
					Ende
				</th>
				<th id="adlist_th">
					Kat
				</th>
				<th id="adlist_th">
					PLZ
				</th>
				<th id="adlist_th">
					Ort
				</th>
				<th id="adlist_th">
					Pos
				</th>
				<th id="adlist_th">
					Einblendungen
				</th>
				<th>
				</th>
				<th>
				</th>
			</tr>
<?php	
	while($adStorage->valid()){
	
		$index 	= $adStorage->key();
		$object = $adStorage->current();
	
		//var_dump($index);
		//var_dump($object);
	?>
			<tr id="adlist_tr">
				<td id="adlist_td">
					<?php echo $object->id; ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->name; ?>
				</td>
				<td id="adlist_td">
					<?php echo date('d.m.Y' ,strtotime( $object->start_date )); ?>
				</td>
				<td id="adlist_td">
					<?php echo date('d.m.Y' ,strtotime( $object->end_date )); ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->categoryid; ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->postcode; ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->city; ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->display_position; ?>
				</td>
				<td id="adlist_td">
					<?php echo $object->times_shown; ?>
				</td>
				<td id="adlist_td">
					<a id="adlist" href="<?php echo $PHP_SELF; ?>?site=editAd&aid=<?php echo $object->id; ?>">Bearbeiten</a>
				</td>
				<td id="adlist_td">
					<a id="adlist" href="javascript:checkConfirm('<?php echo $PHP_SELF; ?>?site=processDel&aid=<?php echo $object->id; ?>', 'Eintrag wirklich löschen?')">Löschen</a>
				</td>
			</tr>

	<?php 	
		$adStorage->next();
	}
	?>
			</table>
			<div style="text-align: right; margin-top: 40px; margin-right: 50px">
				<a href="<?php echo $PHP_SELF."?site=showAllAds"; ?>">Aktualisieren</a>
			</div>
	<?php 
}
elseif ($site == "processAdd"){
	
		$name = $_POST['name'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$image_url = $_POST['image_url'];
		$link_url = $_POST['link_url'];
		$categoryid = $_POST['categoryid'];
		$postcode = $_POST['postcode'];
		$city = $_POST['city'];
		$display_position = $_POST['display_position'];
		$times_shown = $_POST['times_shown'];
		$description = $_POST['description'];
		
		$newAd = new Ad($name, $start_date, $end_date, $image_url, $link_url, $categoryid, $postcode, $city, $display_position, $times_shown, $description);
		$newAd->InsertInDB();
?>
	<div style="width: 100%; margin: 200px auto; text-align: center">
		<span style="font-size: 18px">Werbung wurde eingetragen.</span><br />
		<span style="font-size: 18px"><a href="<?php echo $PHP_SELF; ?>?site=showAddForm">Zurück zur Eingabe</a></span>
	</div>
<?php
}
elseif ($site == "processEdit"){
	
		$aid = $_POST['aid'];
		$name = $_POST['name'];
		$start_date = $_POST['start_date'];
		$end_date = $_POST['end_date'];
		$image_url = $_POST['image_url'];
		$link_url = $_POST['link_url'];
		$categoryid = $_POST['categoryid'];
		$postcode = $_POST['postcode'];
		$city = $_POST['city'];
		$display_position = $_POST['display_position'];
		$times_shown = $_POST['times_shown'];
		$description = $_POST['description'];
		
		$newAd = new Ad($name, $start_date, $end_date, $image_url, $link_url, $categoryid, $postcode, $city, $display_position, $times_shown, $description);
		$newAd->setId($aid);
		$newAd->SaveToDB();
?>
	<div style="width: 100%; margin: 200px auto; text-align: center">
		<span style="font-size: 18px">Werbung wurde geändert.</span><br />
		<span style="font-size: 18px"><a href="<?php echo $PHP_SELF; ?>?site=showAllAds">Zurück zur Übersicht</a></span>
	</div>
<?php
}
elseif ($site == "processDel"){
	
	$aid = $_GET['aid'];
	$newAd = new Ad();
	$newAd->LoadFromDB($aid);
	$newAd->DeleteAd();
?>	
	<div style="width: 100%; margin: 200px auto; text-align: center">
		<span style="font-size: 18px">Werbung "<?php echo $newAd->name; ?>" wurde gelöscht.</span><br />
		<span style="font-size: 18px"><a href="<?php echo $PHP_SELF; ?>?site=showAllAds">Zurück zur Übersicht</a></span>
	</div>
<?php 	
}

?>
</body>
</html>