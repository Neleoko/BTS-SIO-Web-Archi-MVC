<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\DebugHandler;
use Quizz\Core\Service\DatabaseService;
use Quizz\Entity\Etudiant;
use Quizz\Model\EtudiantModel;
use Quizz\Service\TwigService;

class EtudiantController implements ControllerInterface
{

    private $idEtudiant;
    private $post;

    public function inputRequest(array $tabInput)
    {
        if (isset($tabInput["VARS"]["id"])) {
            $this->idEtudiant = $tabInput["VARS"]["id"];
        }

        if(!empty($tabInput["POST"])){
            $this->post = $tabInput["POST"];

        }
    }


    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();

        $etudiant = new EtudiantModel(); //on crée un nouvel objet

        $connect = DatabaseService::getConnect();

        if ($_POST) { //on verifie s'il y a du contenu POST
            $login = $this->post['login'];
            $nom = $this->post['nom'];
            $prenom = $this->post['prenom'];
            $email = $this->post['email'];
            //on met toute les variables POST dans des variables locales

            $verfiemail = filter_var($email, FILTER_VALIDATE_EMAIL); //verification du mail

            if ($verfiemail == true) { //on verifie si le mail est bon
                $modification = $connect->prepare("UPDATE etudiants SET login = '{$login}', nom = '{$nom}', prenom = '{$prenom}', email = '{$email}' WHERE idEtudiant = {$this->idEtudiant};");
                $modification->execute(); //on ajoute l'utilisateur a la base de donnée
            }
        }
        if (isset($this->idEtudiant)) { //on regarde si la variable est null
            echo $twig->render('etudiant/etudiant.html.twig', [
                'etudiant' => $etudiant->getFetchId((int)$this->idEtudiant), //on recupere les informations grace a l'id
            ]);
        }
    }
}