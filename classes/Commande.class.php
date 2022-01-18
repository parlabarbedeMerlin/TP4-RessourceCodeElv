<?php
class Commande
{

    //Attribut
    private $commId;
    private $commDate;
    private $cliId;
    private $compId;


    //Constructeur
    public function __construct($valeur = array())
    {
        if (!empty($valeur)) {
            $this->affect($valeur);
        }
    }

    public function affect($donnees){
        foreach($donnees as $attribut => $valeur){
            switch ($attribut) {
                case 'comm_id':
                    $this->setCommId($valeur);
                    break;
                case 'comm_date':
                    $this->setCommDate($valeur);
                    break;
                case 'cli_id':
                    $this->setCliId($valeur);
                    break;
                case 'comp_id':
                    $this->setCompId($valeur);
                    break;
            }
        }
    }
    //Getter & setter
    //commId
    public function getCommId(){
        return $this->commId;
    }
    public function setCommId($commId){
        $this->commId = $commId;
    }
    //commDate
    public function getCommDate(){
        return $this->commDate;
    }
    public function setCommDate($commDate){
        $this->commDate = $commDate;
    }
    //cliId
    public function getCliId(){
        return $this->cliId;
    }
    public function setCliId($cliId){
        $this->cliId = $cliId;
    }
    //compId
    public function getCompId(){
        return $this->compId;
    }
    public function setCompId($compId){
        $this->compId = $compId;
    }
}