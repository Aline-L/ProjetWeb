<?php session_start(); // on lance une session?>
	<!DOCTYPE html>

 	<html>
		<?php include ("includes/head.php");  // on inclue la balise "head"?> 
	<body>

		<header>
			<section>
				<h1> Un jour, un chaton</h1>
				<p>
					<em>Ce blog vous fera découvrir chaque jour un nouveau petit chaton.</em>
				</p>	
			</section>
		</header>

		<div id="colonneP">
					
			<?php

				include_once("includes/connexion.php"); // on inclus connexion.php de façon unique
				$bdd=connect();	// on se connecte à la base de données

				$result=$bdd->query('SELECT COUNT(Numero_Article) FROM article');	// requete pour accéder au nombre d'articles
				$donnee=$result->fetch();
				$donnee=$donnee['COUNT(Numero_Article)'];
			
				// si ce nombre est 0, il n'y a pas d'article
				if($donnee==0){	
					echo("<p>Il n'y a pas encore d'article sur ce blog!</p>");
				}

				// sinon, on affiche les articles
				else{
									
					// on fait un requete par numero d'article décroissant
					$query1=$bdd->query('SELECT Numero_Article, Titre, Chemin_Resume, Redacteur, DATE_FORMAT(Date_Ajout,\'%d/%m/%Y\') AS Date, Chemin_Image FROM article ORDER BY Numero_Article DESC');
					
					// on parcours les articles en affichant les infos
					while ($donnees=$query1->fetch())
					{
						$num_Article=$donnees['Numero_Article'];
						echo("<article>\n");

							// on affiche le titre, la date et le rédacteur
							echo('<h1>'.$donnees['Titre'].' | posté par '.$donnees['Redacteur'].' le '.$donnees['Date'].'</h1>'."\n");
							
							// on affiche l'image de l'article
							echo('<div class="image_article">'."\n");
								echo('<img src="'.$donnees['Chemin_Image'].'" alt="chat" width=auto height=300px>'."\n");
							echo("</div>\n");
											
							// on affiche le texte de l'article
							echo('<div class="texte_article">'."\n");
								echo("<section>");
									echo('<h2>'.$donnees['Titre'].'</h2>'."\n");
									$fichier=fopen($donnees['Chemin_Resume'],'r');
										if($fichier!=null)
										{
											$ligne=fgets($fichier);
											echo('<p>'."\n");
											while($ligne){
													echo($ligne);
													$ligne=fgets($fichier);
												}
											fclose($fichier);
											echo('</p>'."\n");
										}
										echo('<nav><a href="article.php?id='.$num_Article.'"> Lire la suite... </a></nav>'."\n");
								echo("</section>\n");
												
								// on affiche le dernier commentaire
								echo("<section>\n");
									echo("<h2>Dernier commentaire sur cet article</h2>\n");
											
										$query2 = $bdd->prepare('SELECT Identifiant, DATE_FORMAT(Date_Redaction,\'%d/%m/%Y\') AS Date,
																SUBSTRING(Heure_Redaction, 1, 2) AS Heures,SUBSTRING(Heure_Redaction, 4, 2) AS Minutes, SUBSTRING(Heure_Redaction, 7, 2) AS Secondes
																,Contenu 
																FROM commentaire 
																WHERE Numero_Article=? 
																AND Date_Redaction=(SELECT MAX(Date_Redaction) FROM commentaire WHERE Numero_Article=?)
																AND Heure_Redaction=(SELECT MAX(Heure_Redaction) FROM commentaire WHERE Numero_Article=?)
																');
										$query2->execute(array($num_Article,$num_Article,$num_Article));
										$nbCommentaires=$query2->rowCount();

										// si le nombre de commentaire est 0, on affiche un message
										if($nbCommentaires==0) {
											echo("<p>Il n' y a pas encore de commentaire sur cet article.</p>\n");
											}

										// sinon, on affiche le dernier commentaire
										else{
											$commentaire=$query2->fetch();
											echo('<p><q>'.$commentaire['Contenu'].'</q> - par '.$commentaire['Identifiant'].' le '.$commentaire['Date'].' à '.$commentaire['Heures']. 'h '.$commentaire['Minutes'].'m '.$commentaire['Secondes'].'s </em></p>'."\n");
											}

										$query2->closeCursor();

								echo("</section>\n");
							echo("</div>\n");
						echo("</article>\n");
						}
						$query1->closeCursor();

					}
					$result->closeCursor();
				?>


			</div>

		<?php 
		include("includes/menu.php"); 	//inclusion du menu latéral 
		include("includes/footer.php");	//inclusion du footer 
		?>

		</body>

 </html>
