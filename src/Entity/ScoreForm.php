<?php
namespace App\Entity;

class ScoreForm
{
    protected string $homeTeamName;
    protected string $awayTeamName;

    protected int $homeTeamScore = 0;
    protected int $awayTeamScore = 0;

    public function getAwayTeam(): string { return $this->awayTeamName; }

    public function getAwayTeamScore(): int { return $this->awayTeamScore; }

    public function getHomeTeam(): string { return $this->homeTeamName; }

    public function getHomeTeamScore(): int { return $this->homeTeamScore; }

    public function setHomeTeam(string $name): void { $this->homeTeamName = $name; }

    public function setHomeTeamScore(int $score): void { $this->homeTeamScore = $score; }

    public function setAwayTeam(string $name): void { $this->awayTeamName = $name; }

    public function setAwayTeamScore(int $score): void { $this->awayTeamScore = $score; }
}
?>