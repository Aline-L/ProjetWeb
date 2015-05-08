<?php session_start() ?>
 <!DOCTYPE html>
 <html>

 		<?php include ("includes/head.php"); ?> 

 	 	<body>

			<?php include ("includes/header.php"); ?>

				<div id="colonneP">
						<section>
							<h1> A propos...</h1>
							<p>Ce blog est fait pour les amoureux de chatons, par des amoureux de chatons.</p>
							<p>"Un jour, un chaton" vous propose tous les jours une nouvelle photo de chaton trop mignon pour égayer votre journée.</p>
							<p>Vous pouvez nous écrire à l'adresse mail suivante :</p>
							<p><a href="mailto:unjourunchaton@gmail.com" title="unjourunchaton@gmail.com"> unjourunchaton@gmail.com</a></p>
							<p>N'hésitez pas à nous partager votre passion pour les chatons trognons !</p>
						</section>
				</div>
			
		<?php 
		include("includes/menu.php"); 	//inclusion du menu latéral 
		include("includes/footer.php");	//inclusion du footer 
		?>

		</body>

 </html>
