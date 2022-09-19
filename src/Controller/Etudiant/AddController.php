<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Core\DebugHandler;
use Quizz\Core\Service\DatabaseService;
use Quizz\Service\TwigService;

class AddController implements ControllerInterface
{
    private $post;

    public function inputRequest(array $tabInput)
    {
        if(!empty($tabInput["POST"])){
            $this->post = $tabInput["POST"];
        }
    }

    public function outputEvent()
    {
        $connect = DatabaseService::getConnect();

        if ($_POST) { //on verifie s'il y a du contenu POST
            $login = $this->post['login'];
            $mdp = password_hash($this->post['mdp'], PASSWORD_DEFAULT);
            $nom = $this->post['nom'];
            $prenom = $this->post['prenom'];
            $email = $this->post['email'];
            //on met toute les variables POST dans des variables locales

            $verfiemail = filter_var($email, FILTER_VALIDATE_EMAIL); //verification du mail

            $veriflogin = $connect->prepare("SELECT login FROM etudiants WHERE login = '{$login}';"); // on verifie s'il y a deja un utilisateur dans la bdd
            $veriflogin->execute(); //on execute la requete

            if ($veriflogin->rowCount() == 0) { //on compte combien de colones il y a dans la requete effectué, si c'est = a 0 on execute le code suivant
                if ($_POST['mdp'] == $_POST[    'vmdp']) { //on verifie si les 2 mots de passes sont identiques
                    if ($verfiemail == true){ //on verifie si le mail est bon
                        $inscription = $connect->prepare("INSERT INTO etudiants(login , motDePasse, nom , prenom , email) VALUES ('{$login}' , '{$mdp}' , '{$nom}' , '{$prenom}' , '{$email}');");
                        $inscription->execute(); //on ajoute l'utilisateur a la base de donnée
                        echo "inscription reussi";
                    }else{
                        echo "L'email saisie est incorrect";
                    }
                } else {
                    echo"Veuillez saisir un mot de passe identique";
                }
            }else {
                echo "Le login est deja utilisé";
            }
        }

        $twig = TwigService::getEnvironment();

        echo $twig->render('etudiant/add.html.twig', [

        ]);

    }
}