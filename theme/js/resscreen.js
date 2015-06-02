// @author Cr@zy
// @version 1.0
// @copyright 2009 @ crazyws.fr

function Xhr_ResScreen(file){
	if( window.XMLHttpRequest ){
	  xhr = new XMLHttpRequest();
	  if ( xhr.overrideMimeType ) xhr.overrideMimeType('text/html; charset=ISO-8859-1');
	} else {
	   if ( window.ActiveXObject ){
		try {
		  xhr = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e) {
		  try {
			xhr = new ActiveXObject("Microsoft.XMLHTTP");
		  } catch (e) {
			window.alert("Votre navigateur ne prend pas en charge l'objet XMLHTTPRequest.");
		  }
		}
	  }
	}
 
	if( (new RegExp("[?]", "gi")).test(file) ){
		xhr.open("GET", file + '&rand=' + Math.random(), true);
	} else {
		xhr.open("GET", file + '?rand=' + Math.random(), true);
	}
 
	xhr.setRequestHeader("Content-type", "charset=ISO-8859-1");
	xhr.send(null);
}
	
Xhr_ResScreen('resscreen.php?width='+screen.width+'&height='+screen.height);