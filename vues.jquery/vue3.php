<?php
// Fonction de la vue vue3.php : afficher la demande de changement de mot de passe
// Cette vue est appelée par le contrôleur ctrl3.php
// Ecrit le 20/2/2020 par Jim
?>

<!DOCTYPE html>
<html>
	<head>	
		<title>BTS SIO</title> 
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
		<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
		
		<script>
			// associe une fonction à l'événement pageinit (qui indique que la page est prête)
			$(document).bind('pageinit', function() {
				// on associe une fonction à chaque événement à gérer :
		
				// événement "click" de la case à cocher "caseAfficherMdp" associé à la fonction "afficherMdp"
				$('#caseAfficherMdp').click( afficherMdp );

				// événement "submit" du formulaire "formModificationMdp" associé à la fonction "validationGenerale" 
				// $('#formModificationMdp').submit( validationGenerale );

				
				// affichage du message préparé par le contrôleur avec une fenêtre de dialogue 
				// activée en jQuery dès que la page est prête
				<?php if ($typeMessage == 'avertissement') { ?>
					afficher_avertissement("<?php echo $message; ?>");
				<?php } ?>
				
				<?php if ($typeMessage == 'information') { ?>
					afficher_information("<?php echo $message; ?>");
				<?php } ?>
				
			} );	// fin du "pageinit" du document
		
			// selon l'état de la case, le type des zones de saisie est "text" ou "password"
			function afficherMdp() {
				// tester si la case est cochée
				if ( $("#caseAfficherMdp").is(":checked") ) {
					// les 2 zones passent en <input type="text">
					$('#txtNouveauMdp').attr('type', 'text');
					$('#txtConfirmation').attr('type', 'text');
				}
				else {
					// les 2 zones passent en <input type="password">
					$('#txtNouveauMdp').attr('type', 'password');
					$('#txtConfirmation').attr('type', 'password');
				};
			}
			
			// la fonction validationGenerale() vérifie que les données saisies sont correctes
			// elle retourne un résultat booléen :
			// true valide le submit et permet la transmission des données du formulaire vers le serveur
			// false bloque le submit et empêche la transmission des données du formulaire vers le serveur
			function validationGenerale() {
				if ( estUnMdpCorrect($('#txtNouveauMdp').val() ) == false) {
					afficher_avertissement("Le mot de passe doit comporter au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule et un chiffre !");
					return false;
				}
				if ( $('#txtNouveauMdp').val() != $('#txtConfirmation').val() ) {
					afficher_avertissement("Les 2 valeurs saisies sont différentes !");
					return false;
				}
				// si on arrive ici, c'est que toutes les données sont OK :
				return true;
			}
			
			// la fonction estUnMdpCorrect vérifie que le mot de passe comporte au moins 8 caractères,
			// dont au moins une lettre minuscule, une lettre majuscule et un chiffre
			function estUnMdpCorrect(leMdpAtester) {
				// utilisation d'une expression régulière pour vérifier la force du mot de passe :
				EXPRESSION = "^(.*[0-9].*[a-z].*[A-Z].*|.*[0-9].*[A-Z].*[a-z].*|.*[a-z].*[A-Z].*[0-9].*|.*[a-z].*[0-9].*[A-Z].*|.*[A-Z].*[0-9].*[a-z].*|.*[A-Z].*[a-z].*[0-9].*)$";
				monExprRegul = new RegExp(EXPRESSION);
				// on retourne true si le leMdpAtester est bon et si le leMdpAtester comporte au moins 8 caractères :
				if ( monExprRegul.test (leMdpAtester) == true && leMdpAtester.length >= 8 ) return true;
				else return false;
			}
			
			// la fonction d'affichage d'une information
			function afficher_information(msg) {
				$('#texte_message_information').empty();
				$('#texte_message_information').append(msg);
				// affiche la boîte de dialogue 'affichage_message_information' avec transition flip
				$.mobile.changePage('#affichage_message_information', {transition: "flip"});
				//alert (msg);
			}
			
			// la fonction d'affichage d'un avertissement
			function afficher_avertissement(msg) {
				$('#texte_message_avertissement').empty();
				$('#texte_message_avertissement').append(msg);
				// affiche la boîte de dialogue 'affichage_message_avertissement' avec transition flip
				$.mobile.changePage('#affichage_message_avertissement', {transition: "flip"});
				//alert (msg);
			}
		</script>
	</head> 
	
	<body>
		<div data-role="page" id="page_principale">
			<div data-role="header" data-theme="a">
				<h4>BTS SIO</h4>
				<a href="#" data-ajax="false" data-transition="flip">Retour menu</a>
			</div>
			
			<div data-role="content">
					<h4 style="text-align: center; margin: 10px;">Changer mon mot de passe</h4>
				<form id="formModificationMdp" action="#" method="post" data-ajax="false" >
					<div data-role="fieldcontain">
						<label for="txtNouveauMdp">Nouveau mot de passe :</label>
						<input type="<?php if ($afficherMdp == 'off') echo 'password'; else echo 'text'; ?>" 
							name="txtNouveauMdp" id="txtNouveauMdp" 
							placeholder="Mon nouveau mot de passe" required pattern="^.{8,}$" 
							value="<?php echo $nouveauMdp; ?>" >
					</div>
					<div data-role="fieldcontain">
						<label for="txtConfirmation">Confirmation nouveau mot de passe :</label>
						<input type="<?php if ($afficherMdp == 'off') echo 'password'; else echo 'text'; ?>" 
							name="txtConfirmation" id="txtConfirmation" 
							placeholder="Confirmation de mon nouveau mot de passe" required pattern="^.{8,}$" 
							value="<?php echo $nouveauMdp; ?>" >
					</div>
					<div data-role="fieldcontain" data-type="horizontal" class="ui-hide-label">
						<label for="caseAfficherMdp">Afficher le mot de passe en clair</label>
						<input type="checkbox" name="caseAfficherMdp" id="caseAfficherMdp" data-mini="true" 
						     <?php if ($afficherMdp == 'on') echo 'checked'; ?> >
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnChangerDeMdp" id="btnChangerDeMdp" 
							value="Changer mon mot de passe">
					</div>
				</form>
			</div>
			<div data-role="footer" data-position="fixed" data-theme="a">
				<h4>Annuaire des anciens du BTS Informatique<br>Lycée De La Salle (Rennes)</h4>
			</div>
		</div>
		
		<div data-role="dialog" id="affichage_message_information" data-close-btn="none">
			<div data-role="header" data-theme="a">
				<h3>Information...</h3>
			</div>
			<div data-role="content">
				<p style="text-align: center;"><img src="../images/information.png" class="image" /></p>
				<p id="texte_message_information" style="text-align: center;">Message d'information</p>
			</div>
			<div data-role="footer" class="ui-bar" data-theme="a">
				<a href="#page_principale" data-transition="flip">Fermer</a>
			</div>
		</div>

		<div data-role="dialog" id="affichage_message_avertissement" data-close-btn="none">
			<div data-role="header" data-theme="a">
				<h3>Avertissement...</h3>
			</div>
			<div data-role="content">
				<p style="text-align: center;"><img src="../images/avertissement.png" class="image" /></p>
				<p id="texte_message_avertissement" style="text-align: center;">Message d'avertissement</p>
			</div>
			<div data-role="footer" class="ui-bar" data-theme="a">
				<a href="#page_principale" data-transition="flip">Fermer</a>
			</div>
		</div>
				
	</body>
</html>
					
