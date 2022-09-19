<?php

namespace Quizz\Model;

use Quizz\Core\Service\DatabaseService;
use Quizz\Entity\Etudiant;

class EtudiantModel
{
    private $bdd;

    public function __construct()
    {
        $this->bdd = DatabaseService::getConnect();
    }
    public function getFetchAll(){
        $requete = $this->bdd->prepare("Select idEtudiant, login, nom, prenom, email from etudiants");
        $requete->execute();
        $tabetudiants = [];

        foreach ( $requete->fetchAll() as $value){
            $etudiants = new Etudiant();
            $etudiants->setIdEtudiant($value["idEtudiant"]);
            $etudiants->setLogin($value["login"]);
            $etudiants->setNom($value["nom"]);
            $etudiants->setPrenom($value["prenom"]);
            $etudiants->setEmail($value["email"]);

            $tabetudiants[] = $etudiants;
        }
        return $tabetudiants;
    }
    public function getFetchId(int $id){
        $requete = $this->bdd->prepare("Select idEtudiant, login, nom, prenom, email from etudiants where idEtudiant = ".$id);
        $requete->execute();
        $result = $requete->fetch();

        $etudiant = new Etudiant();
        $etudiant->setIdEtudiant($result["idEtudiant"]);
        $etudiant->setLogin($result["login"]);
        $etudiant->setNom($result["nom"]);
        $etudiant->setPrenom($result["prenom"]);
        $etudiant->setEmail($result["email"]);

        return $etudiant;
    }
}