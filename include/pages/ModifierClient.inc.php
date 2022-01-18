<?php
	$pdo=new Mypdo();

?>
<h1>Modifier une client enregistrée</h1>
<div class="centrerBlock">
<?php
	if(empty($_GET['id'])){
			$clientManager = new ClientManager($pdo);
			$clients=$clientManager->listerClient();
			?>
	<p> Qui souhaitez vous modifier ? </p>
			
			<table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Prénom</th>
            </tr>
            <?php
                foreach($clients as $client){  ?>
                    <tr>
                        <td> 
                        	<a href="index.php?page=3&amp;id=<?php print_r($client->getCliId());?>" title="Afficher détails de <?php print_r($client->getCliPrenom()); ?>">
                           		<?php print_r($client->getCliId());?> 
                            </a> 
                        </td>
                        <td> <?php print_r($client->getCliNom()); ?> </td>
                        <td> <?php print_r($client->getCliPrenom()); ?></td>
                    </tr>		
            <?php	} ?>
            </table>
		
	<?php
	}
	else if(!empty($_GET['id']) and empty($_POST['nomCli']) and empty($_POST['prenomCli'])and empty($_POST['telCli']) and empty($_POST['mailCli']) and empty($_POST['naissanceCli']) and empty($_POST['adresseCli'])){
		$clientManager = new ClientManager($pdo);
		$cliId=$_GET['id'];
		$client = new Client(array('cli_id' => $cliId));
		$cliMod=new Client($clientManager->getOtherClientWithId($client)); ?>
		
			<form action="index.php?page=3&amp;id=<?php print_r($client->getCliId());?>" method="post">
				<table>
					<tr>
						<td class="gauche"><label class="labelC">Nom* : </label></td>
						<td><input class="champ" type="text" name="nomCli" id="nomCli" size="20" value="<?php echo $cliMod->getCliNom() ; ?>" maxlength="30" /></td>
						<td class="gauche"><label class="labelC">Prénom* : </label></td>
						<td><input class="champ" type="text" name="prenomCli" id="prenomCli" size="20" value="<?php echo $cliMod->getCliPrenom() ; ?>" maxlength="30" /></td>
					</tr>
					<tr>
						<td class="gauche"><label class="labelC">Téléphone* : </label></td>
						<td><input class="champ" type="text" name="telCli" id="telCli" size="20" value="<?php echo $cliMod->getCliTel() ; ?>" maxlength="14" /></td>
						<td class="gauche"><label class="labelC">Mail* : </label></td>
						<td><input class="champ" type="text" name="mailCli" id="mailCli" size="20" value="<?php echo $cliMod->getCliMail() ; ?>" maxlength="30"/></td>
					</tr>   
					<tr>
							<td class="gauche"><label class="labelC">Date de Naissance*:</label></td>
							<td><input class="champ" type="date" name="naissanceCli" id="naissanceCli"value="<?php echo $cliMod->getCliNaissance() ; ?>"  size="10" maxlength="10" /></td>
							<td class="gauche"><label class="labelC"> Adresse*:</label></td>
							<td><input class="champ" type="text" name="adresseCli" id="adresseCli"value="<?php echo $cliMod->getCliAdresse() ; ?>" size="20" maxlength="255" /></td>
					</tr>                    
				</table>
				<div><input class="bouton" type="submit" value="Valider" /></div>
				<p class="champOblig"> * Pour garder les anciennes données ne pas modifier</p>
			</form> 
		<?php
	
		}
	
	else if (!empty($_POST['nomCli']) and !empty($_POST['prenomCli'])and !empty($_POST['telCli']) and !empty($_POST['mailCli']) and !empty($_POST['naissanceCli']) and !empty($_POST['adresseCli'])){
		$clientManager = new ClientManager($pdo);
		$cliId=$_GET['id'];
		$client = new Client(array('cli_id' => $cliId));
		$cliMod= new Client($clientManager->getOtherClientWithId($client));		
		$nomClient = $_POST['nomCli'] ;
		$prenomClient = $_POST['prenomCli'] ;
		$telClient = $_POST['telCli'] ;
		$mailClient = $_POST['mailCli'] ;
		$naissanceClient = $_POST['naissanceCli'] ;
		$adresseClient = $_POST['adresseCli'] ;
		
		$idClient = $cliMod->getCliId();
		
		
			if(filter_var($mailClient, FILTER_VALIDATE_EMAIL))
			{
				if (preg_match('#^(0[1-9])(?:[-.]?(\\d{2})){4}$#', $telClient)) {
					
					if (!empty($_SESSION['client'])) {
						unset($_SESSION['client']);
					}
					$cliMod = new Client(array(	'cli_id'=>$idClient,
												'cli_nom'=> $nomClient,
												'cli_prenom'=> $prenomClient,
												'cli_tel'=> $telClient,
												'cli_mail'=> $mailClient,
												'cli_adresse'=> $adresseClient,
												'cli_naissance'=> $naissanceClient));
																 
					$modifiable=true;
					$existeCli=$clientManager-> existantClient($cliMod);
					if(!empty($existeCli)){ 
						if($existeCli['cli_id']!=$cliMod->getCliId()){
							$modifiable=false;
						}
					}
					if($modifiable){
						$retour=$clientManager->modifierClient($cliMod);
										
						?>
							<p class="centrerp"> 
							<img src="image/valid.png" alt="Valider" title="Validation" />
							Les données principales ont bien étaient modifiées </p>
		
						<?php
						}
						else{
							echo "<p> Réessayez ou contactez l'administrateur </p>" ;
						}
					}
				
			else{
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
	}	
	
	
 ?>
</div>
