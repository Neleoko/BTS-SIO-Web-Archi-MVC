<?php

namespace Quizz\Controller\Questionnaire;

use Quizz\Core\Controller\ControllerInterface;
use Quizz\Service\TwigService;

class HelloController implements ControllerInterface
{
    private $id ;

    public function inputRequest(array $tabInput)
    {
        if (isset($tabInput["VARS"]["id"])) {
            $this->id = $tabInput["VARS"]["id"];
        }
    }

    public function outputEvent()
    {
        $twig = TwigService::getEnvironment();
        echo $twig->render('questionnaire/helloworld.html.twig', [
        'id' => $this->id
        ]);

    }
}