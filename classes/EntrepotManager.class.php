<?php
class EntrepotManager{
	
	private $dbo ; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterEntrepot($ent) {
		$retour = -1;
		if($ent instanceof Entrepot){
			$req = $this->db->prepare('INSERT INTO Entrepot (ent_nom, ent_adresse, ent_desc)
										VALUES (:entNom, :entAdresse, :entDesc);');
			$req->bindValue(':entNom', $ent->getEntNom());
			$req->bindValue(':entAdresse', $ent->getEntAdresse());
			$req->bindValue(':entDesc', $ent->getEntDesc());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantEntrepot($ent){
		$sql = 'SELECT ent_id, ent_nom FROM Entrepot WHERE ent_nom=:entNom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':entNom', $ent->getEntNom());
		$req->execute();
		
		$entExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $entExist[0] ;
	}
	
	public function listerEntrepot(){
		$listeEntrepot = array();
		$sql = 'SELECT * FROM entrepot';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($ent=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeEntrepot[]=new Entrepot($ent);
		}
		$requete->closeCursor();
		return $listeEntrepot ;
	}
	
	public function getNbEntrepot() {
		$sql = "SELECT COUNT(DISTINCT ent_id) AS nbEntrepot FROM Entrepot";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbEntrepot = $valeur;
		}
		$requete->closeCursor();
		return $nbEntrepot;
	}
		public function getIdEntrepotWithOther($ent){
		$sql = "SELECT ent_id FROM entrepot WHERE ent_nom = :entNom 
											   AND ent_adresse = :entAdresse 
											   AND ent_desc = :entDesc";

		$req = $this->db->prepare($sql);
		$req->bindValue(':entNom', $ent->getEntNom());
		$req->bindValue(':entAdresse', $ent->getEntAdresse());
		$req->bindValue(':entDesc', $ent->getEntDesc());
		
		$req->execute();
		
		$ent=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $ent['ent_id'] ;
	}
	public function getOtherEntrepotWithId($ent){
		$sql = "SELECT * FROM entrepot WHERE ent_id = :entId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':entId', $ent->getEntId());
		$req->execute();
		
		$ent=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $ent ;
	}
	
    public function supprimerEntrepot($ent) {
		$retour = -1;
		if($ent instanceof Entrepot){
			$req = $this->db->prepare("DELETE FROM entrepot WHERE ent_id = :entId");
			$req->bindValue(':entId', $ent->getEntId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierEntrepot($ent) {
		$retour = -1;
		if($ent instanceof Entrepot){
			$req = $this->db->prepare("UPDATE entrepot SET ent_nom = :entNom, ent_adresse = :entAdresse, ent_desc = :entDesc WHERE ent_id = :entId;");
			$req->bindValue(':entNom', $ent->getEntNom());
			$req->bindValue(':entAdresse', $ent->getEntAdresse());
			$req->bindValue(':entDesc', $ent->getEntDesc());
			$req->bindValue(':entId', $ent->getEntId());

			$retour = $req->execute();		
		}
		return $retour;
	}
}