<?php
// Fonction du contrôleur ctrl3.php : traiter la demande de changement de mot de passe
// Ecrit le 20/2/2020 par Jim

if ( ! isset ($_POST ["txtNouveauMdp"]) && ! isset ($_POST ["txtConfirmation"]) ) {
    // si les données n'ont pas été postées, c'est le premier appel du formulaire ;
    // on affiche alors la vue sans message d'erreur :
    $nouveauMdp = '';
    $confirmationMdp = '';
    $afficherMdp = 'off';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
}
else {
    // récupération des données postées
    if ( empty ($_POST ["txtNouveauMdp"]) == true)  $nouveauMdp = "";
    else   $nouveauMdp = $_POST ["txtNouveauMdp"];
    if ( empty ($_POST ["txtConfirmation"]) == true)  $confirmationMdp = "";
    else   $confirmationMdp = $_POST ["txtConfirmation"];
    if ( empty ($_POST ["caseAfficherMdp"]) == true)  $afficherMdp = 'off';
    else   $afficherMdp = $_POST ["caseAfficherMdp"];
    
    // utilisation d'une expression régulière pour vérifier la force du mot de passe :
    $EXPRESSION = "#^(?=.*[a-z].*$)(?=.*[A-Z].*$)(?=.*[0-9].*$)(?=.{8,}$)#";
    // si le mot de passe n'est pas assez fort, réaffichage de la vue avec un message
    if (!preg_match($EXPRESSION, $nouveauMdp)) {
        $message = 'Le mot de passe doit comporter au moins 8 caractères, dont au moins une lettre minuscule, une lettre majuscule et un chiffre !';
        $typeMessage = 'avertissement';
    }
    else {
        // si les 2 saisies sont différentes, réaffichage de la vue avec un message explicatif
        if ($nouveauMdp != $confirmationMdp) {
            $message = 'Le nouveau mot de passe et sa confirmation sont différents !';
            $typeMessage = 'avertissement';
        }
        else {
            // envoi d'un mail à l'utilisateur avec son nouveau mot de passe
            $sujet = "Modification de votre mot de passe";
            $message = "Votre mot de passe a été modifié.\n\n";
            $message .= "Votre nouveau mot de passe est : " . $nouveauMdp;
            $adresseEmetteur = "delasalle.sio.eleves@gmail.com";
            // pour l'adresse du destinataire, utilisez votre adresse personnelle :
            $adresseDestinataire = "delasalle.sio.haupas.d@gmail.com";
            
            // envoi du mail avec la fonction envoyerMail de la classe Outils.class.php
            include_once ('Outils.class.php');
            $ok = Outils::envoyerMail ($adresseDestinataire , $sujet , $message, $adresseEmetteur);
            
            if ($ok == 1) {
                $message = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
                $typeMessage = 'information';
            }
            else {
                $message = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
                $typeMessage = 'avertissement';
            }
        }
    }
}
include_once ('vue3.php');
