<h1>Liste des commandes enregistrés</h1>
<div class="centrerBlock">
    <?php
    $pdo = new Mypdo();

    if (empty($_GET["id"])){
        $composantManager = new ComposantManager($pdo);
        $clientManager = new ClientManager($pdo);
        $commandeManager = new CommandeManager($pdo);
        $commandes = $commandeManager->listerCommande();
        $nbCommande=$commandeManager->getNbCommande();


        if ($nbCommande>0){
            ?>
            <p>Actuellement <?php echo $nbCommande; ?> commande(s) enregistrée(s)</p>
            <table class="tableau">
                <tr>
                    <th>Identifiant</th>
                    <th>Date</th>
                </tr>
                <?php
                foreach ($commandes as $commande){
                    ?>
                    <tr>
                        <td>
                            <a href="index.php?page=8&amp;id=<?php print_r($commande->getCommId());?>" title="Afficher détails de <?php print_r($commande->getCommId()); ?>">
                            <?php echo $commande->getCommId(); ?></td>
                        <td><?php echo $commande->getCommDate(); ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        }else{?>
            <p class="centrerp">
            <img src="image/erreur.png" alt="Erreur" title="Erreur" />
            Il n'y a aucune commande enregistrée !
        </p>
    <?php
        }
    }
    elseif (!empty($_GET["id"])&&empty($_GET['Suppr'])){
        $commId=$_GET["id"];
        $commande = new Commande(array('comm_id' => $commId));

        $commandeManager = new CommandeManager($pdo);
        $commandes = $commandeManager->getOtherCommandeWithId($commande);
        ?>
        <table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Date</th>
                <th>Client</th>
                <th>Composant</th>
                <th> Supression </th>
            </tr>
            <tr>
                <td><?php echo $commandes['comm_id']; ?></td>
                <td><?php echo $commandes['comm_date']; ?></td>
                <td><?php
                    $clientManager = new ClientManager($pdo);
                    $clienta = new Client(array('cli_id' => $commandes['cli_id']));
                    $clientb = new Client($clientManager->getOtherClientWithId($clienta));
                    echo $clientb->getCliNom();
                    ?></td>
                <td><?php
                    $composantManager = new ComposantManager($pdo);
                    $composanta = new Composant(array('comp_id' => $commandes['comp_id']));
                    $composantb = new Composant($composantManager->getOtherComposantWithId($composanta));
                    echo $composantb->getCompNom()
                    ?></td>
                <td>
                    <a href="index.php?page=8&amp;id=<?php print_r($commande->getCommId());?>&amp;Suppr=1" title="Supprimer <?php print_r($commande->getCommId()); ?>">
                        <img src="image/erreur.png" alt="Supression" title="Supression" />
                    </a>
            </tr>
        </table>
        <?php
    }
    else if((!empty($_GET['id'])&& $_GET['Suppr']==1)){
        $commId=$_GET["id"];
        $commandeManager = new CommandeManager($pdo);
        $commande = new Commande(array('comm_id' => $commId));
        $commSupr=new  Commande($commandeManager->getOtherCommandeWithId($commande));
        $commandeManager->supprimerCommande($commSupr);
        ?>
        <p class="centrerp">
            <img src="image/valid.png" alt="Valider" title="Validation" />
            La commande <?php print_r($commande->getCommId()); ?> a été supprimée !
        </p>
        <script type="text/javascript">
            self.setTimeout("self.location.href = 'index.php?page=0';", 1500) ;
        </script>
    <?php
    }
?>
</div>