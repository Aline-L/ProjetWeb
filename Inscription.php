 <?php session_start() ?>
 <!DOCTYPE html>
 <html>
 
		<?php include ("includes/Head.php"); ?> 

 		 <body>

 		 <?php include ("includes/Header.php"); ?>
 		 <div id="colonneP">
		 <div id="inscription">
			<form id="Inscription" method="post" action="#" >
					<input name="Identifiant" type="text" placeholder="Pseudo">
					<input name="Mail" type="text" placeholder="Adresse e-mail">
					<input name="Mot_de_Passe" type="password" placeholder="Mot de passe">
					<input name="Mot_de_Passe2" type="password" placeholder="Confirmation du mdp">
					<div>
						<input name="Signin" value="S'inscrire" type="submit">
					</div>
				</form>	

		<?php
		if(!isset($_POST['Identifiant']) OR !isset($_POST['Mail'])
			OR !isset($_POST['Mot_de_Passe']) OR !isset($_POST['Mot_de_Passe2'])){

			echo "<p> Veuillez remplir tous les champs ! </p>";	
		}
		
		elseif($_POST['Mot_de_Passe'] != $_POST['Mot_de_Passe2']){
			echo "<p> Mots de passe différents ! </p>";		
		
		}

		if( isset($_POST['Signin']) ) // si formulaire soumis
			{

			include("./includes/Connexion.php");
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

		?>

		</div>
	</div>

 		<?php 
		include("includes/Menu.php"); 	//inclusion du menu latéral 
		include("includes/Footer.php");	//inclusion du footer 
		?>

		</body>
		
 </html>