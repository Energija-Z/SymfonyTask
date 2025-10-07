<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\ScoreForm;
use App\Form\Type\ScoreFormType;

class Controller extends AbstractController
{
    private $var = array();

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        return $this->render("default/index.html.twig");
    }

    #[Route('/newMatch')]
    public function newMatch(Request $request): Response
    {
        $task = new ScoreForm();
        $task->setHomeTeam('France');
        $task->setAwayTeam('Germany');

        $form = $this->createForm(ScoreFormType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            array_push($this->var, $task);
            // ... perform some action, such as saving the task to the database

            //return $this->redirectToRoute('currentMatch');

            /*return $this->render('default/currentMatch.html.twig', [
                'form' => $form,
            ]);*/
        }

        return $this->render('default/newMatch.html.twig', [
            'form' => $form,
        ]);

/*
        $task = new TeamForm();
        //$task->setTask('Write a blog post');
        //$task->setDueDate(new \DateTimeImmutable('tomorrow'));

        $form = $this->createFormBuilder($task)
            ->add('team', TextType::class)
            //->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm();*/
        //return $this->render("default/newMatch.html.twig", ['form' => $form]);
    }

    #[Route('/currentMatch', name: 'currentMatch')]
    public function currentMatch(Request $request): Response
    {
        //$tmp = array_pop($this->var);
        //echo $tmp->getHomeTeam();

        return $this->render('default/currentMatch.html.twig');
    }

    #[Route('/scoreSummary')]
    public function scoreSummary(): Response
    {
        echo($this->var);

        return $this->render("default/scoreSummary.html.twig");
    }
}
?>