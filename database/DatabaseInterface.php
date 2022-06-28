<?php

namespace database;

interface DatabaseInterface
{
    public function query(string $query) : PreparedStatementInterface;
}