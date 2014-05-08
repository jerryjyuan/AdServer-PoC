function checkConfirm(link, text){
	if (text == ""){
		text="Möchten Sie mit dem folgenden Schritt fortfahren?";
	}
	Confirm = confirm(text);
	if (Confirm == true) {
			window.location.href = link;
	}
}

function createPreview(){
	
	postcode = document.getElementById("postcode").value;
	city = document.getElementById("city").value;
	categoryid = document.getElementById("categoryid").value; 
		
	document.getElementById("ifrm_preview").src = "serve.php?plz="+postcode+"&city="+city+"&cat="+categoryid+"&debug=1";
	
}

function setPlaceholderAd(field_id){
	
	document.getElementById(field_id).value = "./img/placeholder_ad.jpg";
	
}

function setPlaceholderLink(field_id){
	
	document.getElementById(field_id).value = "http://www.mevtt.de";
	
}