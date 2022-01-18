<?php
class TypeManager{
	
	private $dbo ; 
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterType($type) {
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare('INSERT INTO Type (type_nom, type_desc)
										VALUES (:typeNom, :typeDesc);');
			$req->bindValue(':typeNom', $type->getTypeNom());
			$req->bindValue(':typeDesc', $type->getTypeDesc());			
						
			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantType($type){
		$sql = 'SELECT type_id, type_nom FROM Type WHERE type_nom=:typeNom';
		$req = $this->db->prepare($sql);
		$req->bindValue(':typeNom', $type->getTypeNom());
		$req->execute();
		
		$typeExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $typeExist[0] ;
	}
	
	public function listerType(){
		$listeType = array();
		$sql = 'SELECT * FROM type';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($type=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeType[]=new Type($type);
		}
		$requete->closeCursor();
		return $listeType ;
	}
	
	public function getNbType() {
		$sql = "SELECT COUNT(DISTINCT type_id) AS nbType FROM type";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbType = $valeur;
		}
		$requete->closeCursor();
		return $nbType;
	}
		public function getIdTypeWithOther($type){
		$sql = "SELECT type_id FROM type WHERE type_nom = :typeNom 
											   AND type_desc = :typeDesc ";

		$req = $this->db->prepare($sql);
		$req->bindValue(':typeNom', $type->getTypeNom());
		$req->bindValue(':typeDesc', $type->getTypeDesc());
		
		$req->execute();
		
		$type=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $type['type_id'] ;
	}
	public function getOtherTypeWithId($type){
		$sql = "SELECT * FROM type WHERE type_id = :typeId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':typeId', $type->getTypeId());
		$req->execute();
		
		$type=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $type ;
	}
		
	public function supprimerType($type) {
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare("DELETE FROM type WHERE type_id = :typeId");
			$req->bindValue(':typeId', $type->getTypeId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierType($type) {
		$retour = -1;
		if($type instanceof Type){
			$req = $this->db->prepare("UPDATE type SET type_nom = :typeNom, type_desc = :typeDesc WHERE type_id = :typeId;");
			$req->bindValue(':typeNom', $type->getTypeNom());
			$req->bindValue(':typeDesc', $type->getTypeDesc());			
			$req->bindValue(':typeId', $type->getTypeId());
			

			$retour = $req->execute();		
		}
		return $retour;
	}
}