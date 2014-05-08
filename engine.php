<?php
function __autoload($class_name){
	require dirname(__FILE__)."/inc/".$class_name.".class.php"; // Diese Funktion lädt die jeweilige PHP-Datei der Klasse bei ihrer ersten Verwendung
}


$ad = new Ad("Werbung 1", 
			 date( 'Y-m-d', mktime(0, 0, 0, 7, 1, 2000)), 
			 date( 'Y-m-d', mktime(0, 0, 0, 7, 1, 2001)),
			 "http://lolbird.com/image.jpg",
			 "http://www.this-is-my-page.com",
			 "1",
			 "65326"); //Erstellt ein neues Ad-Objekt und füllt es direkt mit Werten
$insertid = $ad->InsertInDB(); // Fügt es in die Datenbank ein

$newad = new Ad(); // Erstellt ein neues Objekt aus der Ad-Klasse
$newad->LoadFromDB($insertid); // Lädt die Werbung aus der DB und schreibt sie in das Objekt $newad
$newad->name = "Werbung 08/15"; // Ändert den Namen der Ad innerhalb des Objekts
$newad->SaveToDB(); // Speichert die Änderung in der DB 


/*
 * Folgendermaßen wird ein "Container" erstellt und mit allen vorhandenen Ads als Objekte gefüllt
 * Theoretisch könnte man auch ein Array nehmen, allerdings ist diese Methode a) Objektorientiert und b) Laut einem Benchmark besser
 * 
 * */

$adStorage = new SplObjectStorage(); // Neues Container-Objekt aus der Klasse SplObjectStorage erstelen
$adStorage = Ad::LoadAllFromDB(); // Container-Object mit allen Ads als Objekte füllen (Siehe LoadAllFromDB innerhalb der Ad-Klasse)
$adStorage->rewind(); // Objekt-Container "zurückspuhlen"

while($adStorage->valid()){ // "Während der jeweilige Eintrag valide ist, tue...
	
	$index 	= $adStorage->key(); // derzeitiger index ist der Key des aktiven Objekts (Sowas wie die ID in einer Datenbank, nur halt innerhalb des Objekt-Containers 
	$object = $adStorage->current(); // $object beinhaltet jetzt das aktive Ad-Objekt
	
	//var_dump($index);
	//var_dump($object);
	
	$adStorage->next(); // Springe zum nächsten Objekt im Container
}

?>