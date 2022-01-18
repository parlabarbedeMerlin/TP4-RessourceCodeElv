<h1>Liste des types enregistrées</h1>	
<div class="centrerBlock">
	<?php
		$pdo=new Mypdo();

		if(empty($_GET['id'])){
			$typeManager = new TypeManager($pdo);
			$types=$typeManager->listerType();
			$nbType=$typeManager->getNbType();
   
		if($nbType>0){
		?>
			<p>Actuellement <?php print_r($nbType); ?> types enregistrées : </p>
            <table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
            </tr>
            <?php
                foreach($types as $type){  ?>
                    <tr>
                        <td> 
                        	<a href="index.php?page=12&amp;id=<?php print_r($type->getTypeId());?>" title="Afficher détails de <?php print_r($type->getTypeNom()); ?>">
                           		<?php print_r($type->getTypeId());?> 
                            </a> 
                        </td>
                        <td> <?php print_r($type->getTypeNom()); ?> </td>
                    </tr>		
            <?php	} ?>
            </table>
            <?php
			}else{?>
				<p class="centrerp">
						<img src="image/erreur.png" alt="Erreur" title="Erreur" />
						Il n'y a aucune type enregistré !
				</p>
			<?php
			}
		}
		else if(!empty($_GET['id'])&&empty($_GET['Suppr'])) {
			
			$typeId = $_GET['id'] ;
			$type = new Type(array('type_id' => $typeId ));
			
			$typeManager = new TypeManager($pdo);
			$types=$typeManager->getOtherTypeWithId($type);

			
		?>
		
        <table class="tableau">
        <tr>  
			<th>Nom</th>
			<th>Description</th>

		</tr>
        <tr>
            <td> <?php echo $types['type_nom'] ;?>  </td>
            <td> <?php echo $types['type_desc']; ?> </td>
            <td>
				<a href="index.php?page=12&amp;id=<?php print_r($type->getTypeId());?>&amp;Suppr=1" title="Supprimer <?php print_r($type->getTypeNom()); ?>">
                	<img src="image/erreur.png" alt="Supression" title="Supression" />
                </a> 		
			</td>
		</tr>
	</table>
	<?php
		}
		else if((!empty($_GET['id'])&& $_GET['Suppr']==1)){
			$typeId=$_GET['id'];
			$typeManager = new TypeManager($pdo);
			$type = new Type(array('type_id' => $typeId));
			$typeSupr=new Type($typeManager->getOtherTypeWithId($type));
			$typeManager->supprimerType($typeSupr); 
			?>
			<p class="centrerp">
				<img src="image/valid.png" alt="Valider" title="Validation" />
				Le type <?php echo $typeSupr->getTypeNom() ;?> a bien été suprimé.
			</p> 
			<script type="text/javascript">
				self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
			</script>
		<?php
		}
		?>
        
</div>
