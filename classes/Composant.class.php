<?php
class Composant{
	
	//Attribut
	private $compId;
	private $compNom;
	private $compPrix;
	private $compDesc;
	private $compType;
	private $compEnt;
	
	
	//Constructeur
	public function __construct($valeur = array()){
		if(!empty($valeur)){
			$this->affect($valeur);
		}
	}
		
	public function affect($donnees){
		foreach($donnees as $attribut => $valeur){
			switch ($attribut){
				case 'comp_id':$this->setCompId($valeur);break;
				case 'comp_nom':$this->setCompNom($valeur);break;
				case 'comp_prix':$this->setCompPrix($valeur);break;
				case 'comp_desc':$this->setCompDesc($valeur);break;
				case 'type_id':$this->setCompType($valeur);break;
				case 'ent_id':$this->setCompEnt($valeur);break;

				
			}
		}
	}
	
	//Getteurs et Setteurs
		//Numéro
	public function setCompId($id) {
		$this->compId= $id;
	}
	
	public function getCompId()	{
		return $this->compId;
	}
		//Nom
	public function setCompNom($nom)	{
		$this->compNom = $nom;
	}
	
	public function getCompNom()	{
		return $this->compNom;
	}
		//Prix Composant
	public function setCompPrix($prix) {
		$this->compPrix = $prix;
	}
	
	public function getCompPrix() {
		return $this->compPrix;
	}
		//Description
	public function setCompDesc($desc)	{
		$this->compDesc = $desc;
	}
	
	public function getCompDesc()	{
		return $this->compDesc;
	}
	
			//Type ID 
	public function setCompType($type)	{
		$this->compType = $type;

	}
	
	public function getCompType()	{
		return $this->compType;
	}
	
			//Entrepot ID 
	public function setCompEnt($ent)	{
		$this->compEnt = $ent;
	}
	
	public function getCompEnt()	{
		return $this->compEnt;
	}
}