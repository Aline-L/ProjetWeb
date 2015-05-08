<footer>
	<p>Designed by Aline Legros | Cyril Weller</p>	

	<?php
	include_once("includes/connexion.php");
	$bdd=connect();

	$query = $bdd->prepare('SELECT COUNT(Identifiant) FROM utilisateur');
	$query->execute();
	$resultat = $query->fetch();
	$nbuser=$resultat['COUNT(Identifiant)'];
	
	switch ($nbuser){
		case 0:
		echo '<p>Ce blog ne compte aucun membre</p>';
		break;

		case 1:
		echo '<p>Ce blog compte 1 membre</p>';
		break;

		default:
		echo '<p>Ce blog compte actuellement '.$nbuser.' membres</p>';
		break;
	}
	?>
</footer>