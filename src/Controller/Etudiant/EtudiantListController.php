<?php

namespace Quizz\Controller\Etudiant;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Model\EtudiantModel;
use Quizz\Service\TwigService;

class EtudiantListController implements ControllerInterface
{

    public function inputRequest(array $tabInput)
    {

    }

    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();

        $etudiants = new EtudiantModel(); //on crée un nouvel objet

        echo $twig->render('etudiant/etudiantlist.html.twig', [
            'etudiants' => $etudiants->getFetchAll() //on list tout les etudiants sous forme de tableau

        ]);
    }
}