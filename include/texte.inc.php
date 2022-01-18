<div id="texte">
<?php
if (!empty($_GET["page"])){
	$page=$_GET["page"];}
	else
	{$page=0;
	}
switch ($page) {
//
// Composants
//

case 0:
	// inclure ici la page accueil photo
	include_once('pages/accueil.inc.php');
	break;
	// page insertion nouveau client
case 1:
	// inclure ici la page insertion nouveau clients
	include("pages/ajouterClient.inc.php");
    break;

case 2:
	// inclure ici la page liste des clients
	include_once('pages/listerClient.inc.php');
    break;
case 3:
	// inclure ici la page modification des clients
	include("pages/ModifierClient.inc.php");
    break;
case 4:
	// inclure ici la page insertion nouveau composant
	include_once('pages/ajouterComposant.inc.php');

    break;
case 5:
	// inclure ici la page liste des composants
	include_once('pages/listerComposants.inc.php');

    break;

case 6:
    //COMPLETER CETTE PARTIE POUR QUE LIEN SOIT ACTIF. Question 18
    include_once('pages/ModifierComposant.inc.php');

    break;
case 7:
	//COMPLETER CETTE PARTIE POUR QUE LIEN SOIT ACTIF. Question 26
    include_once('pages/ajouterCommande.inc.php');

    break;
case 8:
	//COMPLETER CETTE PARTIE POUR QUE LIEN SOIT ACTIF. Question 29  
    include_once('pages/listerCommande.inc.php');
    break;
	
case 9:
	// inclure ici la page suppression composants
	include_once('pages/ajouterEntrepot.inc.php');

    break;
	
case 10:
	// inclure ici la page suppression composants
	include_once('pages/listerEntrepot.inc.php');
    break;
	
case 11:
	// inclure ici la page suppression composants
	include_once('pages/ajouterType.inc.php');
    break;
	
case 12:
	// inclure ici la page suppression composants
	include_once('pages/listerType.inc.php');
    break;
    
default : 	include_once('pages/accueil.inc.php');
}
	
?>
</div>
