<?php
class ClientManager{
	
	public function __construct($db) {
		$this->db = $db;
	}
	
	public function ajouterClient($client) {
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare('INSERT INTO Client (cli_nom, cli_prenom, cli_adresse, cli_mail, cli_naissance, cli_tel)
										VALUES (:cliNom, :cliPrenom, :cliAdresse, :cliMail, :cliNaissance, :cliTel);');
			$req->bindValue(':cliNom', $client->getCliNom());
			$req->bindValue(':cliPrenom', $client->getCliPrenom());
			$req->bindValue(':cliAdresse', $client->getCliAdresse());			
			$req->bindValue(':cliMail', $client->getCliMail());
			$req->bindValue(':cliNaissance', $client->getCliNaissance());
			$req->bindValue(':cliTel', $client->getCliTel());

			$retour = $req->execute();		
		}
		return $retour;
	}
	
	public function existantClient($client){
		$sql = 'SELECT cli_id, cli_mail, cli_prenom FROM Client WHERE cli_mail=:cliMail';
		$req = $this->db->prepare($sql);
		$req->bindValue(':cliMail', $client->getCliMail());
		$req->execute();
		
		$clientExist[] = $req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		
		return $clientExist[0] ;
	}
	
	public function listerClient(){
		$listeClient = array();
		$sql = 'SELECT * FROM client';
		$requete = $this->db->prepare($sql);
		$requete->execute();
		
		while($client=$requete->FETCH(PDO::FETCH_ASSOC)){
			$listeClient[]=new Client($client);
		}
		$requete->closeCursor();
		return $listeClient ;
	}
	
	public function getNbClient() {
		$sql = "SELECT COUNT(DISTINCT cli_id) AS nbClient FROM Client";
		$requete = $this->db->prepare($sql);
		$requete->execute();
		$result=$requete->fetch(PDO::FETCH_ASSOC);
		foreach($result as $valeur){
			$nbClient = $valeur;
		}
		$requete->closeCursor();
		return $nbClient;
	}
		public function getIdClientWithOther($client){
		$sql = "SELECT cli_id FROM client WHERE cli_nom = :cliNom 
											   AND cli_prenom = :cliPrenom 
											   AND cli_tel = :cliTel
											   AND cli_mail = :cliMail";

		$req = $this->db->prepare($sql);
		$req->bindValue(':cliNom', $client->getCliNom());
		$req->bindValue(':cliPrenom', $client->getCliPrenom());
		$req->bindValue(':cliTel', $client->getCliTel());
		$req->bindValue(':cliMail', $client->getCliMail());
		
		$req->execute();
		
		$client=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $client['cli_id'] ;
	}
	public function getOtherClientWithId($client){
		$sql = "SELECT * FROM client WHERE cli_id = :cliId ";
		$req = $this->db->prepare($sql);
		$req->bindValue(':cliId', $client->getCliId());
		$req->execute();
		
		$client=$req->FETCH(PDO::FETCH_ASSOC);
		$req->closeCursor();
		return $client ;
	}
	
	
	
	public function supprimerClient($client) {
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare("DELETE FROM client WHERE cli_id = :cliId");
			$req->bindValue(':cliId', $client->getCliId());
			$retour = $req->execute();	
		}
		return $retour;
	}
	
	
	public function modifierClient($client) {
		$retour = -1;
		if($client instanceof Client){
			$req = $this->db->prepare("UPDATE client SET cli_nom = :cliNom, cli_prenom = :cliPrenom, cli_adresse = :cliAdresse, cli_mail = :cliMail, cli_naissance = :cliNaissance, cli_tel = :cliTel WHERE cli_id = :cliId;");
			$req->bindValue(':cliNom', $client->getCliNom());
			$req->bindValue(':cliPrenom', $client->getCliPrenom());
			$req->bindValue(':cliAdresse', $client->getCliAdresse());			
			$req->bindValue(':cliMail', $client->getCliMail());
			$req->bindValue(':cliNaissance', $client->getCliNaissance());
			$req->bindValue(':cliTel', $client->getCliTel());
			$req->bindValue(':cliId', $client->getCliId());
			

			$retour = $req->execute();		
		}
		return $retour;
	}
}