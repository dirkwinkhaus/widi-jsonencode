<?php

declare(strict_types=1);

class generator_model {
    private int $id;
    private string $name;
    private Generator $generator;

    public function __construct(int $id, string $name, Generator $generator)
    {
        $this->id = $id;
        $this->name = $name;
        $this->generator = $generator;
    }

    public function get_id(): int
    {
        return $this->id;
    }

    public function get_name(): string
    {
        return $this->name;
    }

    public function get_generator(): Generator
    {
        return $this->generator;
    }
}
