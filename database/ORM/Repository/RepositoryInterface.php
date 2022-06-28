<?php


namespace database\ORM\Repository;


interface RepositoryInterface
{
    public function findAll(array $orderBy = [], bool $populateNavigationProp = true, array $navigationPropOrderBy = []): \Generator;

    public function findBy(array $where, array $orderBy = [], array $navigationPropOrderBy = []): \Generator;

    public function findOne(array $where, bool $populateNavigationProp = true, array $navigationPropOrderBy = []);
}