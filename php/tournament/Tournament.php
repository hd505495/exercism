<?php

/*
 * By adding type hints and enabling strict type checking, code can become
 * easier to read, self-documenting and reduce the number of potential bugs.
 * By default, type declarations are non-strict, which means they will attempt
 * to change the original type to match the type specified by the
 * type-declaration.
 *
 * In other words, if you pass a string to a function requiring a float,
 * it will attempt to convert the string value to a float.
 *
 * To enable strict mode, a single declare directive must be placed at the top
 * of the file.
 * This means that the strictness of typing is configured on a per-file basis.
 * This directive not only affects the type declarations of parameters, but also
 * a function's return type.
 *
 * For more info review the Concept on strict type checking in the PHP track
 * <link>.
 *
 * To disable strict typing, comment out the directive below.
 */

declare(strict_types=1);

require_once 'Team.php';

class Tournament
{
    private array $teams = [];
    private string $result = "Team                           | MP |  W |  D |  L |  P";

    public function tally(string $scoresInput): string
    {
        $matches = explode("\n", $scoresInput);

        foreach ($matches as $match) {
            $tokens = explode(';', $match);
            
            if (count($tokens) !== 3) continue;

            $team1Name = $tokens[0];
            $team2Name = $tokens[1];
            $outcome = $tokens[2];

            fwrite(STDERR, "team1: $team1Name\n");
            fwrite(STDERR, "team2: $team2Name\n");
            fwrite(STDERR, "outcome: $outcome\n\n");

            $team1 = $this->getOrCreateTeam($team1Name);
            $team2 = $this->getOrCreateTeam($team2Name);

            $this->tallyMatch($team1, $team2, $outcome);
        }

        usort($this->teams, function ($team1, $team2) {
            $team1Score = $team1->getScore();
            $team2Score = $team2->getScore();

            if ($team1Score === $team2Score) {
                return strcmp($team1->getName(), $team2->getName());
            }

            return $team1Score > $team2Score ? 1 : -1;
        });

        foreach ($this->teams as $team) {
            $team->buildScore();

            $teamNamePadded = str_pad($team->getName(), 31);

            $teamResultStr = "\n" . $teamNamePadded . '|  ' .
                        $team->getMatchesPlayed() . ' |  ' .
                        $team->getWins() . ' |  ' .
                        $team->getDraws() . ' |  ' .
                        $team->getLosses() . ' |  ' .
                        $team->getScore();

            $this->result .= $teamResultStr;
        }

        return $this->result;
    }

    private function tallyMatch(Team $team1, Team $team2, string $outcome): void
    {
        $team1->addMatchPlayed();

        switch ($outcome) {
            case 'win':
                $team1->addWin();
                $team2->addLoss();
                break;
            case 'loss':
                $team1->addLoss();
                $team2->addWin();
                break;
            case 'draw':
                $team1->addDraw();
                $team2->addDraw();
                break;
        }
    }

    private function getOrCreateTeam(string $name): Team
    {
        fwrite(STDERR, 'getting or creating ' . $name . "\n");
        $teamNames = array_map(fn ($team) => $team->getName(), $this->teams);

        fwrite(STDERR, "num team names: " . count($teamNames) . "\n");
        fwrite(STDERR, "TEAM NAMES:\n");

        foreach ($teamNames as $existingName) {
            fwrite(STDERR, "$existingName\n");
        }

        // $existingTeamIndex = count($teamNames) > 0 ? array_search($name, $teamNames) : 0;
        $existingTeams = array_filter($this->teams, fn ($team) => $team->getName() === $name);

        // fwrite(STDERR, "existing team index: $existingTeamIndex\n");
        // fwrite(STDERR, "teams arr: $this->teams\n");

        fwrite(STDERR, "num existing team names: " . count($existingTeams) . "\n");
        fwrite(STDERR, "TEAM NAMES:\n");

        foreach ($existingTeams as $exTeam) {
            fwrite(STDERR, "{$exTeam->getName()}\n");
        }

        if (count($existingTeams) === 1) {
            $existingTeam = $existingTeams[0];
            fwrite(STDERR, "type of existing team " . gettype($existingTeam) . "\n");
            fwrite(STDERR, "class of existing team " . get_class($existingTeam) . "\n");
            fwrite(STDERR, "1\n");
            fwrite(STDERR, "found existing team with name {$existingTeam->getName()}\n");
            return $existingTeam;
        }
        fwrite(STDERR, "2\n");

        fwrite(STDERR, "creating new team with name $name\n");

        $newTeam = new Team($name);
        array_push($this->teams, $newTeam);

        return $newTeam;
    }
}
