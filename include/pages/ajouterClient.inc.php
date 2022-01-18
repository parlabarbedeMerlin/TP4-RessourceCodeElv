
<?php
$pdo=new Mypdo();
$clientManager = new ClientManager($pdo);
?>
<h1>Ajouter un Client</h1>
<div class="centrerBlock">
<?php
	if(empty($_POST['nomCli'])){
?>
	<form action="index.php?page=1" method="post">
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Nom* : </label></td>
				<td><input class="champ" type="text" name="nomCli" id="nomCli" size="20" maxlength="30" /></td>
				<td class="gauche"><label class="labelC">Prénom* : </label></td>
				<td><input class="champ" type="text" name="prenomCli" id="prenomCli" size="20" maxlength="30" /></td>
			</tr>
			<tr>
				<td class="gauche"><label class="labelC">Téléphone* : </label></td>
				<td><input class="champ" type="text" name="telCli" id="telCli" size="20" maxlength="14" /></td>
				<td class="gauche"><label class="labelC">Mail* : </label></td>
				<td><input class="champ" type="text" name="mailCli" id="mailCli" size="20" maxlength="30" /></td>
			</tr>
			<tr>
				<td class="gauche"><label class="labelC">Adresse* : </label></td>
				<td><input class="champ" type="text" name="adresseCli" id="adresseCli" size="20" maxlength="100" /></td>
				<td class="gauche"><label class="labelC">Date de Naissance* : </label></td>
				<td><input class="champ" type="date" name="naissanceCli" id="naissanceCli" size="10" maxlength="10" /></td>
			</tr>
		</table>
		<div><input class="bouton" type="submit" value="Valider" /></div>
       	<p class="champOblig"> * champs obligatoires </p>
	</form> 
<?php
	}
	else if(!empty($_POST['nomCli']) and !empty($_POST['prenomCli'])and !empty($_POST['telCli']) and !empty($_POST['mailCli']) and !empty($_POST['naissanceCli']) and !empty($_POST['adresseCli'])){
		$ajoutOK=1;
		$nomClient = $_POST['nomCli'] ;
		$prenomClient = $_POST['prenomCli'] ;
		$adresseClient = $_POST['adresseCli'] ;
		$mailClient = $_POST['mailCli'] ;
		$naissanceClient = $_POST['naissanceCli'] ; 
		$telClient = $_POST['telCli'] ;
		
		if(filter_var($mailClient, FILTER_VALIDATE_EMAIL))
		{
			if (preg_match('#^(0[1-9])(?:[-.]?(\\d{2})){4}$#', $telClient)) {
				if (!empty($_SESSION['client'])) {
					unset($_SESSION['client']);
				}
				$_SESSION['client'] = new Client(array(	'cli_nom'=> $nomClient,
														'cli_prenom'=> $prenomClient,
														'cli_adresse'=> $adresseClient,
														'cli_mail'=> $mailClient,
														'cli_naissance'=> $naissanceClient,
														'cli_tel'=> $telClient));


				$existeCli=$clientManager-> existantClient($_SESSION['client']);
				if(!empty($existeCli)){
				?>
					<p class="centrerp">
						<img src="image/erreur.png" alt="Erreur" title="Erreur" />
						Ce client existe déjà
						<script type="text/javascript">
							self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
						</script>
					</p>
				<?php
				}
			}
			else{
				$ajoutOK=0;
				?>
				
				<p class="centrerp">
					<img src="image/erreur.png" alt="Erreur" title="Erreur" />
					Format du téléphonne invalide
					<script type="text/javascript">
						self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
					</script>
				</p>
			<?php
			}
		}			
		else{
			$ajoutOK=0;
			?>
			<p>
				<img src="image/erreur.png" alt="Erreur" title="Erreur" />
				Format de l'adresse Mail invalide
                <script type="text/javascript">
               		self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
           		</script>
			</p>
		<?php
		}
		if($ajoutOK==1){
			$retourajoutC=$clientManager->ajouterClient($_SESSION['client']);							
			if($retourajoutC==1){ ?>
				<p class="centrerp"> 
					<img src="image/valid.png" alt="Valider" title="Validation" />
					L'insertion de <?php echo $_SESSION['client']->getCliNom()." ".$_SESSION['client']->getCliPrenom()  ;?> s'est bien passée  
					<script type="text/javascript">
						self.setTimeout("self.location.href = 'index.php?page=0';", 2500) ;
					</script>
				</p> 
			<?php
			}
		}
		else{ ?>
			<p class="centrerp"> 
				<img src="image/erreur.png" alt="Erreur" title="Erreur" /> 
				Un problème est survenu pendant l'insertion de <?php echo $_SESSION['client']->getCliNom()." ".$_SESSION['client']->getCliPrenom()  ; ?> rééssayer ou contacter l'administrateur 
			</p> 
		<?php
		}
	}		
	
	else if(empty($_POST['nomCli']) or empty($_POST['prenomCli']) or empty($_POST['telCli']) or empty($_POST['mailCli']) or empty($_POST['naissanceCli']) or empty($_POST['adresseCli'])){ ?>
			
            <p class="centrerp">
            	<img src="image/erreur.png" alt="Erreur" title="Erreur" />
           		Tous les champs marqués d'un astérisque sont obligatoires 
           	</p>
        	<script type="text/javascript">
				self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
           	</script>
        <?php
	}

?>
</div>