<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller extends AbstractController
{
    function __constructor(){
    }
    
    #const $page;
    #new PageStructure();

    #[Route('/')]
    public function index(): Response
    {
        return $this->render("default/index.html.twig");
        //return new Response(new Page()->indexPage());
    }

    #[Route('/newMatch')]
    public function newMatch(): Response
    {

        return $this->render("default/newMatch.html.twig");
    }

    #[Route('/scoreSummary')]
    public function scoreSummary(): Response
    {

        return $this->render("default/scoreSummary.html.twig");
    }

    /*public function new(Request $request): Response
    {
        // createFormBuilder is a shortcut to get the "form factory"
        // and then call "createBuilder()" on it

        $form = $this->createFormBuilder()
            ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->getForm();

        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }*/
}
?>