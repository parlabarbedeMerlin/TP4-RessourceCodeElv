<?php
$pdo = new Mypdo();

?>
<h1>Modifier un composant enregistrée</h1>
<div class="centrerBlock">
    <?php
    if (empty($_GET['id'])) {
        $composantManager = new ComposantManager($pdo);
        $composants = $composantManager->listerComposant();
        ?>
        <p> Qui souhaitez vous modifier ? </p>
        <table class="tableau">
            <tr>
                <th>Identifiant</th>
                <th>Nom</th>
                <th>Prix</th>
            </tr>
            <?php
            foreach ($composants as $composant) { ?>
                <tr>
                    <td>
                        <a href="index.php?page=6&amp;id=<?php print_r($composant->getCompId()); ?>"
                           title="Afficher détails de <?php print_r($composant->getCompPrix()); ?>">
                            <?php print_r($composant->getCompId()); ?>
                        </a>
                    </td>
                    <td> <?php print_r($composant->getCompNom()); ?> </td>
                    <td> <?php print_r($composant->getCompPrix()); ?></td>
                </tr>
            <?php } ?>
        </table>

        <?php
    } else if (!empty($_GET['id']) and empty($_POST['nomcomp']) and empty($_POST['prixcomp']) and empty($_POST['desccomp']) and empty($_POST['entcomp']) and empty($_POST['typecomp'])) {
        $composantManager = new ComposantManager($pdo);
        $compId = $_GET['id'];
        $composant = new Composant(array('comp_id' => $compId));
        $compMod = new Composant($composantManager->getOtherComposantWithId($composant)); ?>

        <form action="index.php?page=6&amp;id=<?php print_r($composant->getCompId()); ?>" method="post">
            <table>
                <tr>
                    <td class="gauche"><label class="labelC">Nom* : </label></td>
                    <td><input class="champ" type="text" name="nomcomp" id="nomcomp" size="20"
                               value="<?php echo $compMod->getCompNom(); ?>" maxlength="30"/></td>
                    <td class="gauche"><label class="labelC">Prix* : </label></td>
                    <td><input class="champ" type="text" name="prixcomp" id="prixcomp" size="20"
                               value="<?php echo $compMod->getCompPrix(); ?>" maxlength="30"/></td>
                </tr>
                <tr>
                    <td class="gauche"><label class="labelC">Desc* : </label></td>
                    <td><input class="champ" type="text" name="desccomp" id="desccomp" size="20"
                               value="<?php echo $compMod->getCompDesc(); ?>"/></td>
                    <td class="gauche"><label class="labelC">Entrepot* : </label></td>
                    <td>
                        <select name='entcomp' id='entcomp' class="champ" value="<?php echo $compMod->getCompEnt(); ?>">
                            <?php
                            $entrepotManager = new EntrepotManager($pdo);
                            $ents = $entrepotManager->listerEntrepot();
                            foreach ($ents as $ent) { ?>
                                <option value='<?php print_r($ent->getEntId()); ?>'> <?php print_r($ent->getEntNom()); ?> </option>
                            <?php }; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="gauche"><label class="labelC">Type*:</label></td>
                    <td>
                        <select name='typecomp' id='typecomp' class="champ"
                                value="<?php echo $compMod->getCompType(); ?>">
                            <?php
                            $typeManager = new TypeManager($pdo);
                            $types = $typeManager->listerType();
                            foreach ($types as $type) { ?>
                                <option value='<?php print_r($type->getTypeId()); ?>'> <?php print_r($type->getTypeNom()); ?> </option>
                            <?php }; ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div><input class="bouton" type="submit" value="Valider"/></div>
            <p class="champOblig"> * Pour garder les anciennes données ne pas modifier</p>
        </form>
        <?php

    } else if (!empty($_POST['nomcomp']) and !empty($_POST['prixcomp']) and !empty($_POST['desccomp']) and !empty($_POST['entcomp']) and !empty($_POST['typecomp'])) {
        $composantManager = new ComposantManager($pdo);
        $compId = $_GET['id'];
        $composant = new Composant(array('comp_id' => $compId));
        $compMod = new Composant($composantManager->getOtherComposantWithId($composant));
        $nomComposant = $_POST['nomcomp'];
        $prixComposant = $_POST['prixcomp'];
        $descComposant = $_POST['desccomp'];
        $entComposant = $_POST['entcomp'];
        $typeComposant = $_POST['typecomp'];

        $idComposant = $compMod->getCompId();

        $compMod = new Composant(array('comp_id' => $idComposant,
            'comp_nom' => $nomComposant,
            'comp_prix' => $prixComposant,
            'comp_desc' => $descComposant,
            'type_id' => $typeComposant,
            'ent_id' => $entComposant));

        $modifiable = true;
        $existeComp = $composantManager->existantComposant($compMod);
        if (!empty($existeComp)) {

        }
        else{
            echo "Erreur : le composant n'existe pas";
        }
        if ($modifiable) {
            $retour = $composantManager->modifierComposant($compMod);

            ?>
            <p class="centrerp">
                <img src="image/valid.png" alt="Valider" title="Validation"/>
                Les données principales ont bien étaient modifiées </p>

            <?php
        } else {
            echo "<p> Réessayez ou contactez l'administrateur </p>";
        }

    }
    else {
        echo "<p> Veuillez remplir tous les champs </p>";
    }


    ?>
</div>
