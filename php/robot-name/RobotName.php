<?php

declare(strict_types=1);

class Robot
{
    private ?string $name = null;
    private static array $namesUsed = [];

    public function __construct()
    {
        $this->name = $this->generateName();
    }

    public function getName(): string
    {
        return $this->name ?? $this->generateName();
    }

    public function reset(): void
    {
        unset($this->name);
    }

    private function generateName(): string
    {
        do {
            $name = chr(random_int(65, 90))
                . chr(random_int(65, 90))
                . random_int(0, 9)
                . random_int(0, 9)
                . random_int(0, 9);
        } while (in_array($name, self::$namesUsed));

        self::$namesUsed[] = $name;

        return $name;
    }
}
