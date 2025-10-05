<?php
namespace App\Controller;
include_once "Page.php";

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller
{
    #const $page;
    
    #new PageStructure();

    #[Route('/')]
    public function index(): Response
    {
        return new Response(new Page()->indexPage());
    }

    #[Route('/newMatch')]
    public function newMatch(): Response
    {

        return new Response(new Page()->newMatchPage());
    }

    #[Route('/scoreSummary')]
    public function scoreSummary(): Response
    {

        return new Response(new Page()->scoreSummaryPage());
    }
}
?>