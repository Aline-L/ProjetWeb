 <?php session_start() ?>
 <!DOCTYPE html>
 <html>
 
		<?php include("./includes/head.php"); ?> 

 		 <body>

 		 <?php include ("./includes/header.php"); ?>
 		 <div id="colonneP">
		 <div id="inscription">
			<form id="Inscription" method="post" action="#" >
					<input name="Identifiant" type="text" placeholder="Pseudo">
					<input name="Mail" type="text" placeholder="Adresse e-mail">
					<input name="Mot_de_Passe" type="password" placeholder="Mot de passe">
					<input name="Mot_de_Passe2" type="password" placeholder="Confirmation mot de passe">
					<input name="Signin" value="S'inscrire" type="submit">
				</form>	

		<?php

	if( isset($_POST['Signin']) ) // si formulaire soumis
	{

		if(empty($_POST['Identifiant']) || empty($_POST['Mail'])
		|| empty($_POST['Mot_de_Passe']) || empty($_POST['Mot_de_Passe2']) ){	//si les champs ne sont pas tous remplis

			echo "<p> Veuillez remplir tous les champs ! </p>";	
		}
		
		elseif($_POST['Mot_de_Passe'] != $_POST['Mot_de_Passe2']){ // si la confirmation du mot de passe est différente
			echo "<p> Mots de passe différents ! </p>";		
		}

		else{

		include_once("includes/connexion.php");
		$bdd=connect();

		/* gestion doublons */
		$query=$bdd->prepare('SELECT Count(Identifiant) FROM utilisateur WHERE Identifiant = ?');
		$query->execute(array($_POST['Identifiant']));

		$resultat=$query->fetch();

			if ($resultat[0]>0){ /* si le pseudo est déjà pris */
				echo '<p> Ce pseudo n\'est pas disponible </p> ';
				$query->closeCursor();
			}

			else{
			/*insertion dans la base de données */
			$date = date('Y-m-d');
			$type = "user";
			$query1=$bdd->prepare('INSERT INTO utilisateur(Identifiant, Mot_de_Passe, Date_Inscription, Type) VALUES(:val1, :val2, :val3, :val4)');
			$query1->execute(array('val1'=>$_POST['Identifiant'], 'val2'=>$_POST['Mot_de_Passe'], 'val3'=>$date,'val4'=>$type));
			echo('<p>Vous êtes inscrit !</p>');
			$query1->closeCursor();
			}
		}
	}	

		?>

		</div>
	</div>

 		<?php 
		include("includes/menu.php"); 	//inclusion du menu latéral 
		include("includes/footer.php");	//inclusion du footer 
		?>

		</body>
		
 </html>