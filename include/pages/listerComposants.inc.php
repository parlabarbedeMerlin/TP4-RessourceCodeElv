<h1>Liste des composants enregistrées</h1>	
<div class="centrerBlock">
	<?php
		$pdo=new Mypdo();

		if(empty($_GET['id'])){
			$composantManager = new ComposantManager($pdo);
			$composants=$composantManager->listerComposant();
			$nbComposant=$composantManager->getNbComposant();
   
		if($nbComposant>0){
		?>
			<p>Actuellement <?php print_r($nbComposant); ?> composants enregistrées : </p>
            <table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Prix</th>
            </tr>
            <?php
                foreach($composants as $composant){  ?>
                    <tr>
                        <td> 
                        	<a href="index.php?page=5&amp;id=<?php print_r($composant->getCompId());?>" title="Afficher détails de <?php print_r($composant->getCompNom()); ?>">
                           		<?php print_r($composant->getCompId());?> 
                            </a> 
                        </td>
                        <td> <?php print_r($composant->getCompNom()); ?> </td>
                        <td> <?php print_r($composant->getCompPrix()); ?> €</td>
                    </tr>		
            <?php	} ?>
            </table>
            <?php
			}else{?>
				<p class="centrerp">
						<img src="image/erreur.png" alt="Erreur" title="Erreur" />
						Il n'y a aucune composant enregistrée !
				</p>
			<?php
			}
		}
		else if(!empty($_GET['id'])&&empty($_GET['Suppr'])) {
			$typeManager = new TypeManager($pdo);
			$entrepotManager = new EntrepotManager($pdo);
			$composantManager = new ComposantManager($pdo);
			
			$compId = $_GET['id'] ;
			$composant = new Composant(array('comp_id' => $compId ));
			
			$composants=$composantManager->getOtherComposantWithId($composant);
			
			$type = new Type(array('type_id' => $composants['type_id'] ));
			$ent = new Entrepot(array('ent_id' => $composants['ent_id'] ));

			
			$type=$typeManager->getOtherTypeWithId($type);
			$ent=$entrepotManager->getOtherEntrepotWithId($ent);



			
		?>
		
        <table class="tableau">
        <tr>  
			<th>Nom</th>
			<th>Prix</th>
            <th> Description </th>
            <th> Type </th>
			<th> Entrepot </th>

			<th> Supression </th>

		</tr>
        <tr>
            <td> <?php echo $composants['comp_nom'] ;?>  </td>
            <td> <?php echo $composants['comp_prix']; ?> </td>
            <td> <?php echo $composants['comp_desc']; ?></td>
            <td> <?php echo $type['type_nom']; ?></td>
			<td> <?php echo $ent['ent_nom']; ?></td>
			<td>
				<a href="index.php?page=5&amp;id=<?php print_r($composant->getCompId());?>&amp;Suppr=1" title="Supprimer <?php print_r($composant->getCompPrix()); ?>">
                	<img src="image/erreur.png" alt="Supression" title="Supression" />
                </a> 		
			</td>
		</tr>
	</table>
	<?php
		}
		else if((!empty($_GET['id'])&& $_GET['Suppr']==1)){
			$compId=$_GET['id'];
			$composantManager = new ComposantManager($pdo);
			$composant = new Composant(array('comp_id' => $compId));
			$compSupr=new Composant($composantManager->getOtherComposantWithId($composant));
			$composantManager->supprimerComposant($compSupr); 
			?>
			<p class="centrerp">
				<img src="image/valid.png" alt="Valider" title="Validation" />
				Le composant <?php echo $compSupr->getCompNom() ;?> a bien été suprimé.
			</p> 
			<script type="text/javascript">
				self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
			</script>
		<?php
		}
		?>
        
</div>
