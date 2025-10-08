<?php
namespace App\Service;

use App\Entity\ScoreForm;

class SharedDataService
{
    public $scores = [];

    public function setScore(ScoreForm $score): void {
        array_push($this->scores, $score);
    }

    public function getScores()
    {
        return $this->scores;
    }
}
?>