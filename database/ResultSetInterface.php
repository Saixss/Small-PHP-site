<?php


namespace database;


interface ResultSetInterface
{
    public function fetchAll(?string $classname = null): \Generator | null;

    public function fetch(?string $classname = null): ?object;

    public function getExecuteSuccess(): bool;

    public function getRowCount(): int;
}