<?php
//require("engine.php");
function __autoload($class_name){
	require dirname(__FILE__)."/inc/".$class_name.".class.php";
}

$minAdsCountToScroll = '5'; // Wenn mindestens soviele Ads vorliegen, wird nicht gescrolled

$city = $_GET['city'];
$postcode = $_GET['plz'];
$categoryid = $_GET['cat'];
if ($_GET['debug'] == "1"){
	$debug = "1";
}
else {
	$debug = "0";
}

$adStorage = new SplObjectStorage();
$adStorage = Ad::ServeAds($postcode, $city, $categoryid);

$adStorage->rewind(); // Objekt-Container "zurückspuhlen"

if ($adStorage->count() >= $minAdsCountToScroll){
	$ticker = '1';

	$text = "    // Die Werbebanner\n";
	$text .= "tNews=new Array();\n";
}
else {
	$ticker = '0';

	$text = "";
}



while($adStorage->valid()){ // "Während der jeweilige Eintrag valide ist, tue...
	
	$object = $adStorage->current(); // $object beinhaltet jetzt das aktive Ad-Objekt
	
	$out = $object->printAd($debug);
	
	
	if ($ticker == '1'){
		$text .= "tNews.push('".$out."');\n";
	}
	else {
		$text .= $out;	
	}
			
	$adStorage->next(); // Springe zum nächsten Objekt im Container
}

echo "\n";

if ($ticker == "1"){
?>


<script type="text/javascript">
<!--
/* * * * * * * * * * * * * * * * D I E  V A R I A B L E N * * * * * * * * * * * * * * * * * */

<?php 
echo $text;
?>

// Laufrichtung(up,down,left,right)
strDir      = 'up';

// Delimiter zwischen den einzelnen News(nur bei left/right)
strDelimiter = '';

// Interval in ms
intInterval = 50;

// Stop bei mouseover?true:false
blnStopHover = true;

// Falls Leeraum zwischen News...hier Wert erhoehen...minimum:1
intRepeat   = 2;

// Rahmen
strBorder   = '0px dotted black';

    //°°°°°°°°°°Breite
intWidth    = 202;

    //°°°°°°°°°°Höhe
intHeight   = 400;

    //Abstand Rahmen->Inhalt
intPadding  = 0;

    //Background-color
strBgc      = '#FFFFFF';

    //Text-color
strTxtc     = '#ffffff';

    //Textausrichtung
strAlign    = 'left';

    //Schritt pro Durchlauf(px)
intStep=1;



/* * * * * * * * * * * * * * * * * * D E R  T I C K E R * * * * * * * * * * * * * * * * * * * * * */

    //IE ab V4?
IE=document.all&&!window.opera;
    //DOM-Browser(ausser IE)
DOM=document.getElementById&&!IE;


//läuft ab IE4 und in DOM-Browsern
if(DOM||IE)
  {
        //Ermitteln, ob Ticker horizontal oder vertikal laufen soll
    blnDir=(strDir=='up'||strDir=='down')?true:false;

        //Bei horizontalem Ticker wird ein nobr-, ansonsten ein div-Tag verwendet
    strNobr=(blnDir)?'div':'nobr';

        //Trennzeichen zwischen den Einzelnen Eintraegen
        //bei horizontalem Ticker gemäss Angabe in Variale strDelimiter
        //Ansonsten Zeilenumbrueche
    strDelimiter=(blnDir)?'':strDelimiter;

        //String fuer Textausrichtung bei vertikalem Ticker
    strAlign=(blnDir)?'text-align:'+strAlign+';':'';

        //Variable zum Speichern des Intervals
    var objGo;
        //Variable zum Speichern der Position
    intPos=0;

        //String erzeugen fuer JS-Code, falls Ticker beim mouseover stoppen soll
    strStopHover=(blnStopHover)?'onmouseover="clearInterval(objGo)"onmouseout="objGo=setInterval(\'DM_ticken()\','+intInterval+')"':'';

        //Tickertext zu String zusammenfuegen
    strText=(blnDir)?tNews.join(strDelimiter)+strDelimiter:tNews.join(strDelimiter)+strDelimiter;
    strNews=strText;

    for(i=1;i<intRepeat;++i)
        {
        strNews+=strText;
        }

        //TickerCode zu String zusammenfuegen
    strTicker='<div style="'+strAlign+'overflow:hidden;background-color:'+strBgc+
                    ';border:'+strBorder+';width:'+intWidth+'px;height:'+intHeight+'px;padding:'+intPadding+
                    'px;"><'+strNobr+'><span id="ticker"style="position:relative;color:'+strTxtc+';background-color:'+strBgc+
                    ';"'+strStopHover+'>'+strNews+'</span></'+strNobr+'></div>';

        //TickerCode im Dokument ausgeben
    document.write(strTicker);

        //Funktion, um Ticker ticken zu lassen
    function DM_ticken()
    {
        //Ticker-Objekt je nach Browser ermitteln
    objTicker=(IE)?document.all.ticker:document.getElementById('ticker');

        //Array fuer zu manipulierende Eigenschaften des Tickers je nach Richtung
        //Richtung=new Array(Pixelwert zur Aenderung der Position,Breite/Höhe des Tickers,zu andernder Positionswert);
    arrDir=new Array();
    arrDir['up']    =new Array(-1,objTicker.offsetHeight,'top');
    arrDir['down']  =new Array(1,objTicker.offsetHeight,'top');
    arrDir['left']  =new Array(1,objTicker.offsetWidth,'left');
    arrDir['right'] =new Array(-1,objTicker.offsetWidth,'left');

        //Ermitteln von Breite bzw. Höhe der anzuzeigenden Items
    dblOffset=arrDir[strDir][1]/intRepeat;

        //Neuen Positionswert ermitteln
    switch(strDir)
        {
        case'right':
            intPos=(Math.abs(intPos)>dblOffset)?0:intPos;break;
        case'left':
            intPos=(intPos>0)?-dblOffset:intPos;break;
        case 'up':
            intPos=(Math.abs(intPos)>dblOffset)?0:intPos;break;
        case 'down':
            intPos=(intPos>0)?-dblOffset:intPos;break;
        }
        //Neuen Positionswert zuweisen
    objTicker.style[arrDir[strDir][2]]=intPos;

        //Positionswert hoch/heruntersetzen
    intPos+=intStep*arrDir[strDir][0];
    }
        //Erneut ticken lassen
    objGo=setInterval('DM_ticken()',intInterval);
  }



//-->
</script>

<?php 
}
else {
	echo $text;
}
?>
