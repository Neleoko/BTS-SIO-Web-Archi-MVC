<?php

namespace Quizz\Controller\Etudiant;


use Quizz\Core\DebugHandler;
use Quizz\Core\Service\DatabaseService;
use Quizz\Service\TwigService;

class DeleteUserController implements \Quizz\Core\Controller\ControllerInterface
{
    private $verifdel = null;
    private $idEtudiant;
    public function inputRequest(array $tabInput)
    {
        if (isset($tabInput["VARS"]["id"])) {
            $this->idEtudiant = $tabInput["VARS"]["id"];
        }
    }

    public function outputEvent()
    {
        $connect = DatabaseService::getConnect();

        $twig = TwigService::getEnvironment();

        $delete = $connect->prepare("DELETE FROM etudiants WHERE idEtudiant = '{$this->idEtudiant}';"); // on supprime l'utilisateur
        $delete->execute();


        echo $twig->render('etudiant/deluser.html.twig', [

        ]);

    }
}