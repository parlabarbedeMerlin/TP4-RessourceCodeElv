<?php
class CommandeManager
{

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function ajouterCommande($commande)
    {
        $retour = -1;
        if ($commande instanceof Commande) {
            $req = $this->db->prepare('INSERT INTO commande(comm_id, comm_date, cli_id, comp_id) VALUES(:commid, :commdate, :cliid, :compid)');
            $req->bindValue(':commid', $commande->getCommId());
            $req->bindValue(':commdate', $commande->getCommDate());
            $req->bindValue(':cliid', $commande->getCliId());
            $req->bindValue(':compid', $commande->getCompId());

            $retour = $req->execute();
        }
        return $retour;
    }

    public function existantCommande($commande)
    {
        $sql = 'SELECT * FROM commande WHERE comm_id = :comm_id';
        $req = $this->db->prepare($sql);
        $req->bindValue(':comm_id', $commande->getCommId());
        $req->execute();

        $commandeExist[] = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $commandeExist[0];
    }
    public function listerCommande()
    {
        $commandes = array();
        $sql = 'SELECT * FROM commande';
        $req = $this->db->prepare($sql);
        $req->execute();

        while ($commande = $req->fetch(PDO::FETCH_ASSOC)) {
            $commandes[] = new Commande($commande);
        }
        $req->closeCursor();
        return $commandes;
    }
    public function getNbCommande(){
        $sql = 'SELECT COUNT(DISTINCT comm_id) AS nbCommande FROM commande';
        $req = $this->db->prepare($sql);
        $req->execute();
        $result=$req->fetch(PDO::FETCH_ASSOC);
        foreach ($result as $value) {
            $nbCommande=$value;
        }
        $req->closeCursor();
        return $nbCommande;
    }

    public function  getIdCommandeWithOther($commande){
        $sql= "SELECT comm_id FROM commande WHERE comm_id = :comm_id 
                                                AND cli_id = :cli_id 
                                                AND comp_id = :comp_id";
        $req = $this->db->prepare($sql);
        $req->bindValue(':comm_id', $commande->getCommId());
        $req->bindValue(':cli_id', $commande->getCliId());
        $req->bindValue(':comp_id', $commande->getCompId());
        $req->execute();
        $commandeExist[] = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $commandeExist['comm_id'];
    }
    //getcommandewithid function
    public function getOtherCommandeWithId($commande){
        $sql = 'SELECT * FROM commande WHERE comm_id = :commid';
        $req = $this->db->prepare($sql);
        $req->bindValue(':commid', $commande->getCommId());
        $req->execute();

        $commande = $req->fetch(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $commande;
    }

    //supprimer commande function
    public function supprimerCommande($commande){
        $retour = -1;
        if ($commande instanceof Commande) {
            $req = $this->db->prepare('DELETE FROM commande WHERE comm_id = :commId');
            $req->bindValue(':commId', $commande->getCommId());
            $retour = $req->execute();
        }
        return $retour;
    }
    public function modifierCommande($commande){
        $retour = -1;
        if ($commande instanceof Commande) {
            $req = $this->db->prepare('UPDATE commande SET comm_date = :comm_date, cli_id = :cli_id, comp_id = :comp_id WHERE comm_id = :comm_id');
            $req->bindValue(':comm_id', $commande->getCommId());
            $req->bindValue(':comm_date', $commande->getCommDate());
            $req->bindValue(':cli_id', $commande->getCliId());
            $req->bindValue(':comp_id', $commande->getCompId());
            $retour = $req->execute();
        }
        return $retour;
    }
}



