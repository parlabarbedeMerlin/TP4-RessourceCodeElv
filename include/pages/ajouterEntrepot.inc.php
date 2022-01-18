
<?php
$pdo=new Mypdo();
$entrepotManager = new EntrepotManager($pdo);
?>
<h1>Ajouter un Entrepot</h1>
<div class="centrerBlock">
<?php
	if(empty($_POST['nomEnt'])){
?>
	<form action="index.php?page=9" method="post">
		<table>
			<tr>
				<td class="gauche"><label class="labelC">Nom* : </label></td>
				<td><input class="champ" type="text" name="nomEnt" id="nomEnt" size="20" maxlength="30" /></td>

			</tr>
			<tr>
				<td class="gauche"><label class="labelC">Desc* : </label></td>
				<td><input class="champ" type="text" name="descEnt" id="descEnt" size="20" maxlength="30" /></td>
			</tr>
			<tr>
				<td class="gauche"><label class="labelC">Adresse* : </label></td>
				<td><input class="champ" type="text" name="adresseEnt" id="adresseEnt" size="20" maxlength="100" /></td>

			</tr>
		</table>
		<div><input class="bouton" type="submit" value="Valider" /></div>
       	<p class="champOblig"> * champs obligatoires </p>
	</form> 
<?php
	}
	else if(!empty($_POST['nomEnt']) and !empty($_POST['descEnt']) and !empty($_POST['adresseEnt'])){
		$nomEntrepot = $_POST['nomEnt'] ;
		$adresseEntrepot = $_POST['adresseEnt'] ;
		$descEntrepot = $_POST['descEnt'] ;
	
		
			
		$ajoutEnt = new Entrepot(array(	'ent_nom'=> $nomEntrepot,
												'ent_adresse'=> $adresseEntrepot,
												'ent_desc'=> $descEntrepot));

		$existeEnt=$entrepotManager-> existantEntrepot($ajoutEnt);
		if(!empty($existeEnt)){
		?>
			<p class="centrerp">
				<img src="image/erreur.png" alt="Erreur" title="Erreur" />
				Ce entrepot existe déjà
				<script type="text/javascript">
					self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
				</script>
			</p>
		<?php
		}			
			
		else{
			$retourajoutC=$entrepotManager->ajouterEntrepot($ajoutEnt);							
			if($retourajoutC==1){ ?>
				<p class="centrerp"> 
					<img src="image/valid.png" alt="Valider" title="Validation" />
					L'insertion de <?php echo $ajoutEnt->getEntNom();?> s'est bien passée  
					<script type="text/javascript">
						self.setTimeout("self.location.href = 'index.php?page=0';", 2500) ;
					</script>
				</p> 
			<?php
			}
		}
		
	}
	else if(empty($_POST['nomEnt']) or empty($_POST['descEnt']) or empty($_POST['adresseEnt'])){ ?>
			
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