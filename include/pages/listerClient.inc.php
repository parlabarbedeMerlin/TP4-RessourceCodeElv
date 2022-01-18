<h1>Liste des clients enregistrées</h1>	
<div class="centrerBlock">
	<?php
		$pdo=new Mypdo();

		if(empty($_GET['id'])){
			$clientManager = new ClientManager($pdo);
			$clients=$clientManager->listerClient();
			$nbClient=$clientManager->getNbClient();
   
		if($nbClient>0){
		?>
			<p>Actuellement <?php print_r($nbClient); ?> clients enregistrées : </p>
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
                        	<a href="index.php?page=2&amp;id=<?php print_r($client->getCliId());?>" title="Afficher détails de <?php print_r($client->getCliPrenom()); ?>">
                           		<?php print_r($client->getCliId());?> 
                            </a> 
                        </td>
                        <td> <?php print_r($client->getCliNom()); ?> </td>
                        <td> <?php print_r($client->getCliPrenom()); ?></td>
                    </tr>		
            <?php	} ?>
            </table>
            <?php
			}else{?>
				<p class="centrerp">
						<img src="image/erreur.png" alt="Erreur" title="Erreur" />
						Il n'y a aucune client enregistrée !
				</p>
			<?php
			}
		}
		else if(!empty($_GET['id'])&&empty($_GET['Suppr'])) {
			
			$cliId = $_GET['id'] ;
			$client = new Client(array('cli_id' => $cliId ));
			
			$clientManager = new ClientManager($pdo);
			$clients=$clientManager->getOtherClientWithId($client);

			
		?>
		
        <table class="tableau">
        <tr>  
			<th>Nom</th>
			<th>Prénom</th>
            <th> Mail </th>
            <th> Tel </th>
			<th> Supression </th>

		</tr>
        <tr>
            <td> <?php echo $clients['cli_nom'] ;?>  </td>
            <td> <?php echo $clients['cli_prenom']; ?> </td>
            <td> <?php echo $clients['cli_mail']; ?></td>
            <td> <?php echo $clients['cli_tel']; ?></td>
			<td>
				<a href="index.php?page=2&amp;id=<?php print_r($client->getCliId());?>&amp;Suppr=1" title="Supprimer <?php print_r($client->getCliPrenom()); ?>">
                	<img src="image/erreur.png" alt="Supression" title="Supression" />
                </a> 		
			</td>
		</tr>
	</table>
	<?php
		}
		else if((!empty($_GET['id'])&& $_GET['Suppr']==1)){
			$cliId=$_GET['id'];
			$clientManager = new ClientManager($pdo);
			$client = new Client(array('cli_id' => $cliId));
			$cliSupr=new Client($clientManager->getOtherClientWithId($client));
			$clientManager->supprimerClient($cliSupr); 
			?>
			<p class="centrerp">
				<img src="image/valid.png" alt="Valider" title="Validation" />
				Le client <?php echo $cliSupr->getCliNom() ;?> a bien été suprimé.
			</p> 
			<script type="text/javascript">
				self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
			</script>
		<?php
		}
		?>
        
</div>
