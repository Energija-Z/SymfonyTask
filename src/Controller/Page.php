<?php
namespace App\Controller;
class Page {
    private function bodyElementComponent(): string {
        return '<html><body>';
    }

    private function bodyElementCloseComponent(): string {
        return '</html></body>';
    }

    private function indexLinkComponent(): string {
        return '<a href="/">Return to index</a>';
    }

    public function indexPage(): string {
        return $this->bodyElementComponent().'
            <h1>Welcome to the Live Football Score!</h1>
            <h2>Please select one of these options:</h2>
            <a href="/newMatch">New match</a>
            <a href="/scoreSummary">Score list</a>
        '.$this->bodyElementCloseComponent();
    }

    public function newMatchPage(): string {
        return $this->bodyElementComponent().
            $this->indexLinkComponent().'
            <h1>Please enter the two teams:</h1>
            <label>Home team: <input type="text" name="homeTeam"/></label><br/>
            <label>Away team: <input type="text" name="awayTeam"/></label><br/>
            <button>Submit</button>
        '.$this->bodyElementCloseComponent();
    }

    public function scoreSummaryPage(): string {
        return $this->bodyElementComponent().
            $this->bodyElementComponent().'
            <ul>
                <li>henlo</li>
            </ul>
        '.$this->bodyElementCloseComponent();
    }
}
?>