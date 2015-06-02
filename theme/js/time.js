init.push(function () {
            $('#styled-finputs-example').pixelFileInput({ placeholder: 'No file selected...' });
          })
function getFileSimple(id,adr){$.ajax({"url":adr, "success":function(data){
$(id).html(data);
}});}
$("div.lazy").lazyload({
effect : "fadeIn"
});
$(document).ready( function() {
	$("#episode").select2({
							allowClear: true,
							placeholder: "Selectionner une saison"
						});
	$("select").change(function () {
	$("#episode_desc").load("index.php?view=episode_detail"+$("#episode").val()+"");
	setInterval(function() {
	     $("#episode_desc").load("index.php?view=episode_detail"+$("#episode").val()+"");
	}, 5000);
});
	$( "#goflix" ).submit(function( event ) {
  event.preventDefault();
});
// détection de la saisie dans le champ de recherche
$('#q').keyup( function(){
$field = $(this);
$('#results').html(''); // on vide les resultats
$('#ajax-loader').remove(); // on retire le loader

// on commence à traiter à partir du 2ème caractère saisie
if( $field.val() && $field.val().length > 1 )
{
	clearTimeout($field.data('timeout'));

	$field.data('timeout', setTimeout(function () {
		// on envoie la valeur recherché en GET au fichier de traitement
		$.ajax({
			type : 'GET', // envoi des données en GET ou POST
			url : 'index.php?view=search&cli=1' , // url du fichier de traitement
			data : 'recherche=' + $field.val() , // données à envoyer en  GET ou POST
			beforeSend : function() { // traitements JS à faire AVANT l'envoi
				$field.after(''); // ajout d'un loader pour signifier l'action
			},
			success : function(data){ // traitements JS à faire APRES le retour d'ajax-search.php
				$('#results').html(data); // affichage des résultats dans le bloc
			}
		});
	}, 200));
}		
});
});
