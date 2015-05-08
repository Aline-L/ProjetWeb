<?php
	session_start();
	if(isset($_SESSION['Identifiant'])){ 
	$identifiant=$_SESSION['Identifiant'];
	}
?>
 <!DOCTYPE html>
 <html>

 	<?php include ("includes/head.php"); ?> 

		<body>

			<?php include ("includes/header.php"); ?>

				<div id="colonneP">

						<?php
							if(isset($_GET['id']) && (ctype_digit($_GET['id']))){
								$num_Article=$_GET['id'];
								
								include("includes/connexion.php");
								$bdd=connect();
																
								$query1 = $bdd->prepare('SELECT Titre, Chemin_Contenu, Redacteur, DATE_FORMAT(Date_Ajout,\'%d/%m/%Y\') AS Date, Chemin_Image 
														FROM article 
														WHERE Numero_Article=?');
								$query1->execute(array($num_Article));
								$donnees=$query1->fetch();
								if($donnees!=null){
									echo('<article class="pageArticle" >'."\n");
										echo('<h1>'.$donnees['Titre'].' | posté par '.$donnees['Redacteur'].' le '.$donnees['Date'].'</h1>'."\n");
										echo('<img src="'.$donnees['Chemin_Image'].'" alt="chat" width=auto height=300px>'."\n");
										echo("<section>\n");
											echo('<h2>'.$donnees['Titre'].'</h2>'."\n");
											$fichier=fopen($donnees['Chemin_Contenu'],'r');
											if($fichier!=null){
												$ligne=fgets($fichier);
												echo('<p>'."\n");
												while($ligne){
													echo($ligne);
													$ligne=fgets($fichier);
												}
												fclose($fichier);
												echo('</p>'."\n");
											}
										echo("</section>\n");
									echo("</article>");
								}
								else{
									header('Location: index.php');
								}
								$query1->closeCursor();
								
/*---------------------------------------PARTIE COMMENTAIRES---------------------------------------------------------*/
								echo('<div id="commentairesArticle">'."\n");
									echo('<h1>Commentaires</h1>'."\n");
									$query2 = $bdd->prepare('SELECT Identifiant, DATE_FORMAT(Date_Redaction,\'%d/%m/%Y\') AS Date, Heure_Redaction, 
															SUBSTRING(Heure_Redaction, 1, 2) AS Heures,SUBSTRING(Heure_Redaction, 4, 2) AS Minutes, SUBSTRING(Heure_Redaction, 7, 2) AS Secondes,
															Contenu 
															FROM commentaire 
															WHERE Numero_Article=? 
															ORDER BY Date_Redaction, Heure_Redaction'
															);
										$query2->execute(array($num_Article));	
										$nbCommentaires=$query2->rowCount();
										if($nbCommentaires==0){
											echo('<div class="commentaire">'."\n");
												echo("<p>Il n' y a pas encore de commentaire sur cet article.</p>\n");
											echo('</div>'."\n");
										}
										else{
												while($commentaire=$query2->fetch()){
													echo('<div class="commentaire">'."\n");
														if(isset($commentaire['Contenu'])){
															echo('<p><em>Par '.$commentaire['Identifiant'].' le '.$commentaire['Date'].' à '.$commentaire['Heures']. 'h '.$commentaire['Minutes'].'m '.$commentaire['Secondes'].'s </em></p>'."\n");
															echo('<q>'.$commentaire['Contenu'].'</q>'."\n");
														}
													echo('</div>'."\n");
											}
										}
							$query2->closeCursor();
								if(isset($_SESSION['Identifiant'])){
									echo('<form action="#" method="post">
										<textarea placeholder="Tapez votre commentaire ici - 500 caractères maximum" cols="80" rows="5" name="Commentaire" maxlength="500"></textarea>
									<input type="submit" name="envoiCommentaire" value="Envoyer">');

									if(isset($_POST['envoiCommentaire'])){
										if(!empty($_POST['Commentaire'])) {
											$date= date('Y-m-d');
											$heure=date('H:i:s');
											$query2 = $bdd->prepare('INSERT INTO commentaire(Numero_Article, Identifiant, Date_Redaction, Heure_Redaction, Contenu) VALUES (:val1, :val2, :val3,CURRENT_TIME(),:val4)');
											$query2->execute(array('val1'=>$num_Article, 'val2'=>$identifiant,'val3'=>$date,'val4'=>$_POST['Commentaire']));
											header("Refresh: 0");
										}
									}
								}
								else{
									echo("<p>Connectez-vous ou inscrivez-vous pour laisser un commentaire!</p>\n");
								}

							}
							else{
								header('Location: index.php');
							}
							?>
						</form>	
				</div>
		</div>
			
		<?php 
		include("includes/menu.php"); 	//inclusion du menu latéral 
		include("includes/footer.php");	//inclusion du footer 
		?>

		</body>


 </html>
