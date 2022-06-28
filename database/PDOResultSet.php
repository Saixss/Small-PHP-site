<?php


namespace database;


use core\DataBinder\DataBinder;

class PDOResultSet implements ResultSetInterface
{
    /**
     * @var \PDOStatement
     */
    private \PDOStatement $stm;

    /**
     * @var bool
     */
    private bool $executeSuccess;

    /**
     * PDOResultSet constructor.
     * @param \PDOStatement $stm
     * @param bool $executeSuccess
     */
    public function __construct(\PDOStatement $stm, bool $executeSuccess)
    {
        $this->stm = $stm;
        $this->executeSuccess = $executeSuccess;
    }

    /**
     * @param string|null $classname
     * @return \Generator | null
     */
    public function fetchAll(?string $classname = null): \Generator | null
    {
        $dataBinder = new DataBinder();

        $row = $this->stm->fetch(\PDO::FETCH_ASSOC);

        do {
            if ($row === false) {
                return null;
            }

            if ($classname === null) {
                yield (object)$row;
            } else {
                yield $dataBinder->bind($row, $classname);
            }
        } while($row = $this->stm->fetch(\PDO::FETCH_ASSOC));
    }

    /**
     * @param string|null $classname
     * @return object|null
     */
    public function fetch(?string $classname = null): ?object
    {
        $dataBinder = new DataBinder();

        $result =  $this->stm->fetch(\PDO::FETCH_ASSOC);

        if ($classname === null) {
            return (object)$result;
        }

        if ($result !== false) {
            return $dataBinder->bind($result, $classname);
        } else {
            return null;
        }
    }

    /**
     * @return bool
     */
    public function getExecuteSuccess(): bool
    {
        return $this->executeSuccess;
    }

    public function getRowCount(): int
    {
        return $this->stm->rowCount();
    }
}