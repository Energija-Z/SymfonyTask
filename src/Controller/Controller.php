<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\ScoreForm;
use App\Form\Type\ScoreFormType;
use App\Form\Type\SearchType;

class Controller extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render("default/index.html.twig");
    }

    #[Route('/scoreSummary')]
    public function scoreSummary(): Response
    {
        echo($this->var);

        return $this->render("default/scoreSummary.html.twig");
    }


    #[Route('/newMatch', name: "newMatch")]
    public function newMatch(Request $request): Response
    {
        $form = $this->createForm(ScoreFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
 
            $dataHomeTeam = $task['homeTeam'];
            $dataAwayTeam = $task['awayTeam'];

            return $this->redirectToRoute('currentMatch', [
                "homeTeam" => $dataHomeTeam,
                "awayTeam" => $dataAwayTeam
            ]);
        }

        return $this->render('default/newMatch.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/currentMatch/{homeTeam},{awayTeam}', name: 'currentMatch')]
    public function currentMatch(string $homeTeam, string $awayTeam): Response
    {        
        return $this->render('default/currentMatch.html.twig', [
            "homeTeam" => $homeTeam,
            "awayTeam" => $awayTeam
        ]);
    }
}
?>