<?php
$pdo=new Mypdo();
$commandeManager=new CommandeManager($pdo);
$clientManager=new ClientManager($pdo);
$composantManager=new ComposantManager($pdo);

if (empty($_POST['cliId'])){
    $clients=$clientManager->listerClient();
}
if (empty($_POST['compId'])){
    $composants=$composantManager->listerComposant();
}

?>
<h1>Ajouter un Commande</h1>
<div class="centrerBlock">
<?php
	if(empty($_POST['commDate'])){
?>
	<form  method="post">
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Date* : </label></td>
				<td><input class="champ" type="date" name="commDate" id="commDate" size="20" maxlength="30" /></td>

			</tr>
			<tr>
				<td class="gauche"><label class="labelC">cliId* : </label></td>
				<td>
                    <select name="cliId" id="cliId" class="champ">
                        <?php
                        foreach($clients as $client){ ?>
                            <option value ='<?php print_r($client->getCliId()); ?>'> <?php print_r($client->getCliNom()); ?> </option>
                        <?php }; ?>
                    </select>
                </td>
			</tr>
			<tr>
				<td class="gauche"><label class="labelC">commId* : </label></td>
				<td>
                    <select name="compId" id="compId" class="champ">
                        <?php
                        foreach($composants as $composant){ ?>
                            <option value ='<?php print_r($composant->getCompId()); ?>'> <?php print_r($composant->getCompNom()); ?> </option>
                        <?php }; ?>
                    </select>
                </td>

			</tr>
		</table>
		<div><input class="bouton" type="submit" value="Valider" /></div>
       	<p class="champOblig"> * champs obligatoires </p>
	</form>
<?php
	}
	else if(!empty($_POST['commDate']) and !empty($_POST['cliId']) and !empty($_POST['compId'])){
		$commDate = $_POST['commDate'] ;
		$compId = $_POST['compId'] ;
		$cliId = $_POST['cliId'] ;
		$ajoutComm = new Commande(array('comm_date'=> $commDate,
                                        'comp_id'=> $compId,
                                        'cli_id'=> $cliId));

		$existeComm=$commandeManager-> existantCommande($ajoutComm);
		if(!empty($existeComm)){
		?>
			<p class="centrerp">
				<img src="image/erreur.png" alt="Erreur" title="Erreur" />
				Ce commande existe déjà
				<script type="text/javascript">
					self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
				</script>
			</p>
		<?php
		}

		else{
			$retourajoutC=$commandeManager->ajouterCommande($ajoutComm);
			if($retourajoutC==1){ ?>
				<p class="centrerp">
					<img src="image/valid.png" alt="Valider" title="Validation" />
					L'insertion de <?php echo $ajoutComm->getCommId();?> s'est bien passée
					<script type="text/javascript">
						self.setTimeout("self.location.href = 'index.php?page=0';", 2500) ;
					</script>
				</p>
			<?php
			}
		}

	}
	else if(empty($_POST['commDate']) or empty($_POST['cliId']) or empty($_POST['compId'])){ ?>

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