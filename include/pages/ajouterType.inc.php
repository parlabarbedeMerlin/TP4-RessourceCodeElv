
<?php
$pdo=new Mypdo();
$typeManager = new TypeManager($pdo);
?>
<h1>Ajouter un Type</h1>
<div class="centrerBlock">
<?php
	if(empty($_POST['nomType'])){
?>
	<form action="index.php?page=11" method="post">
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Nom* : </label></td>
				<td><input class="champ" type="text" name="nomType" id="nomType" size="20" maxlength="30" /></td>
				<td class="gauche"><label class="labelC">Description* : </label></td>
				<td><input class="champ" type="text" name="descriptionType" id="descriptionType" size="30"  maxlength="255" /></td>
			</tr>
			
		</table>
		<div><input class="bouton" type="submit" value="Valider" /></div>
       	<p class="champOblig"> * champs obligatoires </p>
	</form> 
<?php
	}
	else if(!empty($_POST['nomType']) and !empty($_POST['descriptionType'])){
		$nomType = $_POST['nomType'] ;
		$descriptionType = $_POST['descriptionType'] ;
		$ajoutType = new Type(array(	'type_nom'=> $nomType,
										'type_desc'=> $descriptionType));
		$existeType=$typeManager-> existantType($ajoutType);
		if(!empty($existeType)){
		?>
			<p class="centrerp">
				<img src="image/erreur.png" alt="Erreur" title="Erreur" />
				Ce type existe déjà
				<script type="text/javascript">
					self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
				</script>
			</p>
		<?php
		}			
		else{
			$retourajoutC=$typeManager->ajouterType($ajoutType);							
			if($retourajoutC==1){ ?>
			<p class="centrerp"> 
				<img src="image/valid.png" alt="Valider" title="Validation" />
				L'insertion de <?php echo $ajoutType->getTypeNom() ;?> s'est bien passée  
				<script type="text/javascript">
					self.setTimeout("self.location.href = 'index.php?page=0';", 2500) ;
				</script>
			</p> 
			<?php
			}
			else{ ?>
				<p class="centrerp"> 
					<img src="image/erreur.png" alt="Erreur" title="Erreur" /> 
					Un problème est survenu pendant l'insertion de <?php echo $ajoutType->getTypeNom() ; ?> rééssayer ou contacter l'administrateur 
				</p> 
			<?php
			}
		}
	}		
	else if(empty($_POST['nomType']) or empty($_POST['descriptionType']) or empty($_POST['telType']) or empty($_POST['mailType']) or empty($_POST['naissanceType']) or empty($_POST['adresseType'])){ ?>
			
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