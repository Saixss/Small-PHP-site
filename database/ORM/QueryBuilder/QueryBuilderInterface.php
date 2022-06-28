<?php


namespace database\ORM\QueryBuilder;


use database\ResultSetInterface;

interface QueryBuilderInterface
{
    public function insert(string $table, array $values = []): ResultSetInterface;

    public function update(string $table, array $values = [], array $whereClause = []): ResultSetInterface;

    public function delete(string $table, array $whereClause): ResultSetInterface;

    public function select(array $columns = []): QueryBuilderInterface;

    public function from(string $table): QueryBuilderInterface;

    public function where(array $criteria = []): QueryBuilderInterface;

    public function orderBy(array $order): QueryBuilderInterface;

    public function groupBy(array $columns): QueryBuilderInterface;

    public function innerJoin(string $table, array $on): QueryBuilderInterface;

    public function leftJoin(string $table, array $on): QueryBuilderInterface;

    public function rightJoin(string $table, array $on): QueryBuilderInterface;

    public function avg($value): string;

    public function sum($value): string;

    public function min($value): string;

    public function max($value): string;

    public function count($value): string;

    public function build(bool $paginate = false, int $elPerPage = 10, int $numOfDisplayedPages = 10): ResultSetInterface;
}