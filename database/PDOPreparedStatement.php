<?php


namespace database;


class PDOPreparedStatement implements PreparedStatementInterface
{
    private \PDOStatement $stm;

    public function __construct(\PDOStatement $stm)
    {
        $this->stm = $stm;
    }

    public function execute(array $params = []): ResultSetInterface
    {
        $executeSuccess = $this->stm->execute($params);

        return new PDOResultSet($this->stm, $executeSuccess);
    }
}