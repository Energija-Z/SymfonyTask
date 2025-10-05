<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Controller
{
    #[Route('/initial')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html>
                <body>
                    <h1>Welcome to the Live Football Score!</h1>
                    <h2>Please select one of these options:</h2>
                    <a href="/new-game">New match</a>
                    <a href="/score-list">Score list</a>
                </body>
            </html>'
        );
    }
}