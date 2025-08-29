<?php

declare(strict_types=1);

class Team
{
    private string $name = '';
    private int $score = 0;
    private int $wins = 0;
    private int $draws = 0;
    private int $losses = 0;
    private int $matchesPlayed = 0;

    public function __construct($name)
    {
        fwrite(STDERR, "__construct new team with name $name\n");
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addWin(): void
    {
        $this->wins += 1;
    }

    public function getWins(): int
    {
        return $this->wins;
    }

    public function addDraw(): void
    {
        $this->draws += 1;
    }

    public function getDraws(): int
    {
        return $this->draws;
    }

    public function addLoss(): void
    {
        $this->losses += 1;
    }

    public function getLosses(): int
    {
        return $this->losses;
    }

    public function addMatchPlayed(): void
    {
        $this->matchesPlayed += 1;
    }

    public function getMatchesPlayed(): int
    {
        return $this->matchesPlayed;
    }

    public function buildScore(): void
    {
        $this->score = ($this->wins * 3) + $this->draws;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}