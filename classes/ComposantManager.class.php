<?php
class ComposantManager{
	
	private $dbo ; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterComposant($composant) {
		$retour = -1;
		if($composant instanceof Composant){
			$req = $this->db->prepare('INSERT INTO `composant`(`comp_nom`, `comp_prix`, `comp_desc`, `type_id`, `ent_id`) VALUES (:compNom,:compPrix,:compDesc,:compType,:compEnt)');
			$req->bindValue(':compNom', $composant->getCompNom());
			$req->bindValue(':compPrix', $composant->getCompPrix());
			$req->bindValue(':compDesc', $composant->getCompDesc());
			$req->bindValue(':compType', $composant->getCompType());
			$req->bindValue(':compEnt', $composant->getCompEnt());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantComposant($composant){
		$sql = 'SELECT comp_nom, comp_prix FROM Composant WHERE comp_nom=:compNom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':compNom', $composant->getCompNom());
		$req->execute();
		
		$composantExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $composantExist[0] ;
	}
	
	public function listerComposant(){
		$listeComposant = array();
		$sql = 'SELECT * FROM composant';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($composant=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeComposant[]=new Composant($composant);
		}
		$requete->closeCursor();
		return $listeComposant ;
	}
	
	public function getNbComposant() {
		$sql = "SELECT COUNT(DISTINCT comp_id) AS nbComposant FROM Composant";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbComposant = $valeur;
		}
		$requete->closeCursor();
		return $nbComposant;
	}
		public function getIdComposantWithOther($composant){
		$sql = "SELECT comp_id FROM composant WHERE comp_nom = :compNom 
											   AND comp_prix = :compPrix ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':compNom', $composant->getCompNom());
		$req->bindValue(':compPrix', $composant->getCompPrix());
	
		$req->execute();
		
		$composant=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $composant['comp_id'] ;
	}
	public function getOtherComposantWithId($composant){
		$sql = "SELECT * FROM composant WHERE comp_id = :compId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':compId', $composant->getCompId());
		$req->execute();
		
		$composant=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $composant ;
	}
	
		public function supprimerComposant($composant) {
		$retour = -1;
		if($composant instanceof Composant){		
			$req = $this->db->prepare("DELETE FROM composant WHERE comp_id = :compId");
			$req->bindValue(':compId', $composant->getCompId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierComposant($composant) {
		$retour = -1;
		if($composant instanceof Composant){
			$req = $this->db->prepare("UPDATE composant SET comp_nom = :compNom, comp_prix = :compPrix, comp_desc = :compDesc, type_id = :compType, ent_id = :compEnt WHERE comp_id = :compId;");;
			$req->bindValue(':compId', $composant->getCompId());
			$req->bindValue(':compNom', $composant->getCompNom());
			$req->bindValue(':compPrix', $composant->getCompPrix());
			$req->bindValue(':compDesc', $composant->getCompDesc());
			$req->bindValue(':compType', $composant->getCompType());
			$req->bindValue(':compEnt', $composant->getCompEnt());
			
			$retour = $req->execute();
		}
		return $retour;
	}
}