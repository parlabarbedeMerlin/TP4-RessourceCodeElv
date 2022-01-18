<?php
class Entrepot{
	
	//Attribut
	private $entId;
	private $entNom;
	private $entAdresse;
	private $entDesc;

	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'ent_id':$this->setEntId($valeur);break;
				case 'ent_nom':$this->setEntNom($valeur);break;
				case 'ent_adresse':$this->setEntAdresse($valeur);break;
				case 'ent_desc':$this->setEntDesc($valeur);break;
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setEntId($id) {
		$this->entId = $id;
	}
	
	public function getEntId()	{
		return $this->entId;
	}
		//Nom
	public function setEntNom($nom)	{
		$this->entNom = $nom;
	}
	
	public function getEntNom()	{
		return $this->entNom;
	}

		//Adresse
	public function setEntAdresse($adresse)	{
		$this->entAdresse = $adresse;
	}
	public function getEntAdresse() {
		return $this->entAdresse;
	}
	
		//Description
	public function setEntDesc($desc) {
		$this->entDesc = $desc;
	}
	public function getEntDesc() {
		return $this->entDesc;
	}
	

	
}