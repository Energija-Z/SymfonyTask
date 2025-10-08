<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\ScoreForm;
use App\Form\Type\TeamFormType;
use App\Form\Type\ScoreFormType;
use App\Form\Type\SearchType;
use App\Service\SharedDataService;

class Controller extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(SharedDataService $sds): Response
    {
        foreach($sds->getScores() as $i)
            echo $i." score";
        return $this->render("default/index.html.twig");
    }

    #[Route('/scoreSummary/{homeTeam},{awayTeam},{homeTeamScore},{awayTeamScore}', name: "scoreSummary")]
    public function scoreSummary(string $homeTeam, string $awayTeam, int $homeTeamScore, int $awayTeamScore, SharedDataService $sds): Response
    {
        $sds->setScore(new ScoreForm($homeTeam, $awayTeam, $homeTeamScore, $awayTeamScore));
        return $this->render("default/scoreSummary.html.twig", [
            "homeTeam" => $homeTeam,
            "homeTeamScore" => $homeTeamScore
        ]);
    }

    #[Route('/newMatch', name: "newMatch")]
    public function newMatch(Request $request): Response
    {
        $form = $this->createForm(TeamFormType::class);

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
    public function currentMatch(string $homeTeam, string $awayTeam, Request $request): Response
    {
        $form = $this->createForm(ScoreFormType::class);
        $form->get("homeTeamScore")->setData(0);
        $form->get("awayTeamScore")->setData(0);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();

            /*
            <label for="{{ form.homeTeamScore }}">{{homeTeam}} {{ form_row(form.homeTeamScore) }}</label>
            <label for="{{ form.homeTeamScore }}">{{awayTeam}} {{ form_row(form.homeTeamScore) }}</label>
             */
 
            return $this->redirectToRoute('scoreSummary', [
                "homeTeam" => $homeTeam,
                "awayTeam" => $awayTeam,
                "homeTeamScore" => $task["homeTeamScore"],
                "awayTeamScore" => $task["awayTeamScore"]
            ]);
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