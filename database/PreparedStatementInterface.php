<?php


namespace database;


interface PreparedStatementInterface
{
    public function execute(array $params = []): ResultSetInterface;
}