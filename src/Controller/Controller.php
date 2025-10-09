<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\ScoreForm;
use App\Form\Type\TeamFormType;
use App\Form\Type\ScoreFormType;
use App\Form\Type\SearchType;
use App\Service\SharedDataService;

class Controller extends AbstractController
{
    /**
     * Homepage with links.
     */
    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render("default/index.html.twig");
    }

    /**
     * Page that lists the teams and their scores.
     */
    #[Route('/scoreSummary', name: "scoreSummary")]
    public function scoreSummary(SessionInterface $session): Response
    {
        return $this->render("default/scoreSummary.html.twig", [
            "data" => $session->get("match"),
        ]);
    }

    /**
     * Form to write team names.
     * It navigates to current match page.
     */
    #[Route('/newMatch', name: "newMatch")]
    public function newMatch(Request $request): Response
    {
        $form = $this->createForm(TeamFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            return $this->redirectToRoute('currentMatch', [
                "homeTeam" => $task['homeTeam'],
                "awayTeam" => $task['awayTeam']
            ]);
        }

        return $this->render('default/newMatch.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * Form to set score for teams. User can also let the page be, as the scores can increment themselves through a JS script, until the button is pressed.
     * It navigates to score summary page.
     */
    #[Route('/currentMatch/{homeTeam},{awayTeam}', name: 'currentMatch')]
    public function currentMatch(string $homeTeam, string $awayTeam, Request $request, SessionInterface $session): Response
    {
        $form = $this->createForm(ScoreFormType::class);
        $form->get("homeTeamScore")->setData(0);
        $form->get("awayTeamScore")->setData(0);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            $cursor = 1;
            $homeTeamScore = $task["homeTeamScore"];
            $awayTeamScore = $task["awayTeamScore"];

            $newMatch = new ScoreForm($homeTeam, $awayTeam, $homeTeamScore, $awayTeamScore);

            if($session->get("match")){
                $matchArray = $session->get("match");
                array_unshift($matchArray, $newMatch);

                $a = usort($matchArray, function($previous, $next){
                    $totalPreviousScore = $previous->getHomeTeamScore() + $previous->getAwayTeamScore();
                    $totalNextScore = $next->getHomeTeamScore() + $next->getAwayTeamScore();
                    return $totalPreviousScore <
                    
                    $totalNextScore ? 1 : -1;
                });

                $session->set("match", $matchArray);
            }
            else
                $session->set("match", array($newMatch));

            return $this->redirectToRoute('scoreSummary');
        }

        return $this->render('default/currentMatch.html.twig', [
            'form' => $form,
            "homeTeam" => $homeTeam,
            "awayTeam" => $awayTeam,
            "homeTeamScore" => 0,
            "awayTeamScore" => 0
        ]);
    }
}
?>