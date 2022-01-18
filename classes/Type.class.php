<?php
class Type{
	
	//Attribut
	private $typeId;
	private $typeNom;
	private $typeDesc;

	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'type_id':$this->setTypeId($valeur);break;
				case 'type_nom':$this->setTypeNom($valeur);break;
				case 'type_desc':$this->setTypeDesc($valeur);break;
				
			}
		}
	}
	
	//Getteurs et Setteurs
		//Identifiant
	public function setTypeId($id) {
		$this->typeId = $id;
	}
	
	public function getTypeId()	{
		return $this->typeId;
	}
		//Nom
	public function setTypeNom($nom)	{
		$this->typeNom = $nom;
	}
	
	public function getTypeNom()	{
		return $this->typeNom;
	}
		//Prénom
	public function setTypeDesc($desc) {
		$this->typeDesc = $desc;
	}
	public function getTypeDesc() {
		return $this->typeDesc;
	}
		
}