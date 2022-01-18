<h1>Liste des entrepots enregistrées</h1>
<div class="centrerBlock">
    <?php
    $pdo=new Mypdo();

    if(empty($_GET['id'])){
        $entrepotManager = new EntrepotManager($pdo);
        $entrepots=$entrepotManager->listerEntrepot();
        $nbEntrepot=$entrepotManager->getNbEntrepot();

    if($nbEntrepot>0){
        ?>
        <p>Actuellement <?php print_r($nbEntrepot); ?> entrepots enregistrées : </p>
        <table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Adresse</th>
            </tr>
            <?php
            foreach($entrepots as $entrepot){  ?>
                <tr>
                    <td>
                        <a href="index.php?page=10&amp;id=<?php print_r($entrepot->getEntId());?>" title="Afficher détails de <?php print_r($entrepot->getEntNom()); ?>">
                            <?php print_r($entrepot->getEntId());?>
                        </a>
                    </td>
                    <td> <?php print_r($entrepot->getEntNom()); ?> </td>
                    <td> <?php print_r($entrepot->getEntAdresse()); ?></td>
                </tr>
            <?php	} ?>
        </table>
        <?php
    }else{?>
        <p class="centrerp">
            <img src="image/erreur.png" alt="Erreur" title="Erreur" />
            Il n'y a aucune entrepot enregistrée !
        </p>
    <?php
    }
    }
    else if(!empty($_GET['id'])&&empty($_GET['Suppr'])) {

    $entId = $_GET['id'] ;
    $entrepot = new Entrepot(array('ent_id' => $entId ));

    $entrepotManager = new EntrepotManager($pdo);
    $entrepots=$entrepotManager->getOtherEntrepotWithId($entrepot);


    ?>

        <table class="tableau">
            <tr>
                <th>Nom</th>
                <th>Adresse</th>
                <th> Desc </th>
                <th> Supression </th>

            </tr>
            <tr>
                <td> <?php echo $entrepots['ent_nom'] ;?>  </td>
                <td> <?php echo $entrepots['ent_adresse']; ?> </td>
                <td> <?php echo $entrepots['ent_desc']; ?></td>
                <td>
                    <a href="index.php?page=10&amp;id=<?php print_r($entrepot->getEntId());?>&amp;Suppr=1" title="Supprimer <?php print_r($entrepot->getEntNom()); ?>">
                        <img src="image/erreur.png" alt="Supression" title="Supression" />
                    </a>
                </td>
            </tr>
        </table>
    <?php
    }
    else if((!empty($_GET['id'])&& $_GET['Suppr']==1)){
    $entId=$_GET['id'];
    $entrepotManager = new EntrepotManager($pdo);
    $entrepot = new Entrepot(array('ent_id' => $entId));
    $entSupr=new Entrepot($entrepotManager->getOtherEntrepotWithId($entrepot));
    $entrepotManager->supprimerEntrepot($entSupr);
    ?>
        <p class="centrerp">
            <img src="image/valid.png" alt="Valider" title="Validation" />
            Le entrepot <?php echo $entSupr->getEntNom() ;?> a bien été suprimé.
        </p>
        <script type="text/javascript">
            self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
        </script>
        <?php
    }
    ?>

</div>
