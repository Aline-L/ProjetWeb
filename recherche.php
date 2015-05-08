<?php session_start() ?>
<!DOCTYPE html>
 <html>
	<?php include ("includes/head.php"); ?> 
	<body>

		<?php include ("includes/header.php"); ?>



		<div id ="colonneP">

		<?php if (empty($_SESSION['Recherche'])){
			echo '<h2> Veuillez entrer des mot-clés pour la recherche ! </h2>';
		}

		else{?>


			<div id="resultatsRecherche">
					<h1> Résultat(s) de la recherche : "<?php echo $_SESSION['Recherche']; ?>" </h1>



					<div class="resultatRecherche">

		<?php 
			
			$request = $_SESSION['Recherche'];
			include("includes/connexion.php");
			$bdd=connect();
			$query=$bdd->prepare('SELECT *, DATE_FORMAT(Date_Ajout,\'%d/%m/%Y\') AS Date FROM article WHERE Titre LIKE "%'.$request.'%" ');
			$query->execute();
			$nb=$query->rowCount();

			// si il n'y a pas d'articles correspondant, on affiche un message
			if($nb==0) {
				echo("<p>Il n'y a aucun article correspondant à la recherche.</p>\n");
			}

			// sinon, on affiche un liste des articles
			else{
				while ($resultat = $query->fetch()) {

						echo '<div class="resultatRecherche">
						<h2> '.$resultat['Titre'].
						' | posté par '.$resultat['Redacteur'].
						' le '.$resultat['Date'].'</h2>'.
						'<h3><a href="article.php?id='.$resultat['Numero_Article'].'">Lien vers l\'article </a> <h3>
						</div>';
				}

			$query->closeCursor();
			}
		}

		?>
		</div>
		</div>
		</div>
			
		<?php 
		include("includes/menu.php"); 	//inclusion du menu latéral 
		include("includes/footer.php");	//inclusion du footer 
		?>

		</body>
		
 </html>