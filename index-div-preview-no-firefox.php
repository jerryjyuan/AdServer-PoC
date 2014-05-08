<?php
//require("engine.php");
function __autoload($class_name){
	require dirname(__FILE__)."/inc/".$class_name.".class.php";
}
?>

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
<div style="padding-top: 30px; padding-left: 100px; width: 800px; margin: auto">
	<span style="font-family: tahoma; size: 12pt">AdServer-Administration</span>
</div>

<div id="tabs">
    <ul>
        <li style="margin-left: 1px" id="tabHeaderActive"><a href="javascript:void(0)" onClick="toggleTab(1,3)"><span>Werbung hinzufügen</span></a></li>
        <li id="tabHeader2"><a href="javascript:void(0)" onClick="toggleTab(2,3)" ><span>Werbung verwalten</span></a></li>
        <li id="tabHeader3"><a href="javascript:void(0)" onclick="toggleTab(3,3)"><span>Vorschau</span></a></li>
    </ul>
</div>
<div id="tabscontent" style="padding-left: 100px">
    <div id="tabContent1" class="tabContent" style="display:yes">
        <div style="height: 500px">
            
            <iframe src="admanage.php?site=showAddForm" style="width: 99%; height: 99%; border: 0px">
            Ihr Browser unterstützt leider keine Frames. Bitte verwenden Sie einen Browser, der diese unterstützt.
            </iframe>
            
        </div>
    </div>
    <div id="tabContent2" class="tabContent" style="display:none">
        <div style="height: 500px">
                	   
			<iframe src="admanage.php?site=showAllAds" style="width: 99%; height: 99%; border: 0px">
            Ihr Browser unterstützt leider keine Frames. Bitte verwenden Sie einen Browser, der diese unterstützt.
            </iframe>
            
        </div>
    </div>
    <div id="tabContent3" class="tabContent" style="display:none">
        <div style="height: 500px">
            Bitte Kategorie und optional PLZ <b>oder</b> Ort eingeben um die Vorschau der Werbeeinblendungen zu erhalten.<br />
            <br />
              <div style="margin: auto; width: 650px">
            	<div style="float: left; left: 10px">
            	<table>
            		<tr>
            			<td>
            				PLZ
            			</td>
            			<td>
            				<input type="text" id="postcode" maxlength="5" style="width: 200px" />
            			</td>
            		</tr>
            		<tr>
						<td>
							Ort
						</td>
						<td>
							<input type="text" id="city" style="width: 200px" />
						</td>
					</tr>
					<tr>
						<td>
							Kategorie&nbsp;&nbsp;&nbsp;	
						</td>
						<td>
							<select id="categoryid" style="width: 200px">
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
						<td></td>
						<td align="center">
							<input type="button" name="btnSubmit" value="Anzeigen" onClick="javascript:createPreview();" style="margin-top: 20px"/>
						</td>
					</tr>
            	</table>
            </div>
            <div style="position: relative; top: 3px; left: 20px; border: 1px dotted black; width: 300px; height: 400px">
            	
				<iframe id="ifrm_preview" style="width: 99%; height: 99%; border: 0px">
					Ihr Browser unterstützt leider keine Frames. Bitte verwenden Sie einen Browser, der diese unterstützt.
				</iframe>

            </div>
           </div>
            
        </div>
    </div>
</div>


</body>
</html>