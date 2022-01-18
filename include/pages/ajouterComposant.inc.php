
<?php
$pdo=new Mypdo();
$composantManager = new ComposantManager($pdo);
$typeManager = new TypeManager($pdo);
$entrepotManager = new EntrepotManager($pdo);

if(empty($_POST['type_id'])){
				$types=$typeManager->listerType();
			}
if(empty($_POST['ent_id'])){
				$ents=$entrepotManager->listerEntrepot();
			}		
?>
<h1>Ajouter un composant</h1>
<div class="centrerBlock">
<?php
	if((empty($_POST['nomComp']))and(empty($_POST['PrixComp']))and(empty($_POST['DescriptionComp']))){
?>
	<form action="index.php?page=4" method="post">
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Nom* : </label></td>
				<td><input class="champ" type="text" name="nomComp" id="nomComp" size="20" maxlength="30" /></td>
				<td class="gauche"><label class="labelC">Prix* : </label></td>
				<td><input class="champ" type="text" name="PrixComp" id="PrixComp" size="20" maxlength="10" /></td>
			</tr>
				
		</table>
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Description* : </label> </td>
				<td><input class="champ" type="text" name="DescriptionComp" id="DescriptionComp" size="50" maxlength="256" /></td>
			</tr>
		</table>	
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Type* : </label></td>
				<td>
					<select name='type_id' id='type_id' class="champ" >
						<?php 
						foreach($types as $type){ ?>
							<option value ='<?php print_r($type->getTypeId()); ?>'> <?php print_r($type->getTypeNom()); ?> </option>
						<?php }; ?>
					</select>
				</td>
				<td class="gauche"><label class="labelC">Entrepot* : </label></td>
				<td>
					<select name='ent_id' id='ent_id' class="champ">
						<?php 						
						foreach($ents as $ent){ ?>
							<option value ='<?php print_r($ent->getEntId()); ?>'> <?php print_r($ent->getEntNom()); ?> </option>
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
	else if(!empty($_POST['nomComp']) and !empty($_POST['PrixComp']) and !empty($_POST['DescriptionComp'])  and !empty($_POST['type_id'])  and !empty($_POST['ent_id'])){
		
		$nomComp = $_POST['nomComp'] ;
		$prixComp = $_POST['PrixComp'] ;
		$descriptionComp = $_POST['DescriptionComp'] ;
		$typeComp = $_POST['type_id'] ;
		$entComp = $_POST['ent_id'] ;
		
		
		$ajoutComp = new Composant(array(	'comp_nom'=> $nomComp,
														'comp_prix'=> $prixComp,
														'comp_desc'=> $descriptionComp,
														'type_id' => $typeComp,
														'ent_id'=> $entComp));
		$existeCom=$composantManager-> existantComposant($ajoutComp);
		if(!empty($existeComp)){
			?>
			<p class="centrerp">
				<img src="image/erreur.png" alt="Erreur" title="Erreur" />
				Erreur ce composant existe déjà
				<script type="text/javascript">
					self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
				</script>
			</p>
			
		<?php
		}
		else{
			$retourajoutC=$composantManager->ajouterComposant($ajoutComp);
		
			if($retourajoutC){
			?>
			<p class="centrerp"> 
				<img src="image/valid.png" alt="Valider" title="Validation" />
				L'insertion du composant : <?php echo $ajoutComp->getCompNom()." au prix de : ".$ajoutComp->getCompPrix()  ;?>€ s'est bien passée  
			</p> 
			<?php
			}
		else{ ?>
			<p class="centrerp"> 
				<img src="image/erreur.png" alt="Erreur" title="Erreur" /> 
				Un problème est survenu pendant l'insertion de <?php echo $ajoutComp->getCompNom()." au prix de : ".$ajoutComp->getCompPrix()  ; ?>€ rééssayer ou contacter l'administrateur 
			</p> 
		<?php
		}
								
		}
	}	

	else if(empty($_POST['nomComp']) or empty($_POST['PrixComp']) or empty($_POST['DescriptionComp']) ){ ?>
			
            <p class="centrerp">
            	<img src="image/erreur.png" alt="Erreur" title="Erreur" />
           		Tous les champs marqués d'un astérisque sont obligatoires 
           	</p>
        	<script type="text/javascript">
				self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
           	</script>
        <?php
		
	}
	

	else{?>
		<p class="centrerp">
			<img src="image/erreur.png" alt="Erreur" title="Erreur" />
			Un problème est survenu contacter l'administrateur
		</p>
		<?php
	}
	
	

?>
</div>