<?php


namespace database\ORM\QueryBuilder;


use core\Paginator\Paginator;
use core\Paginator\PaginatorInterface;
use database\DatabaseInterface;
use database\ResultSetInterface;


class MySQLQueryBuilder implements QueryBuilderInterface
{
    private DatabaseInterface $db;

    private string $query;

    private array $whereClause = [];

    private string $table;

    private bool $paginate = false;


    public function __construct(DatabaseInterface $db)
    {
        $this->db = $db;
        $this->query = "";
    }

    public function insert(string $table, array $values = []): ResultSetInterface
    {
        $query =
            "INSERT INTO $table ("
            . implode(", ", array_keys($values))
            . ") VALUES ("
            . implode(", ", array_fill(0, count($values), "?"))
            . ")";

        return $this->db->query($query)->execute(array_values($values));
    }

    public function update(string $table, array $values = [], array $whereClause = []): ResultSetInterface
    {
        $query = "UPDATE $table SET ";

        foreach (array_keys($values) as $tableColumn) {

           $query .= "$tableColumn = ?, ";
        }

        $query = rtrim($query, ", ");
        $query .= " WHERE 1=1 ";

        foreach (array_keys($whereClause) as $column) {

            $query .= "AND $column = ?";
        }

        return $this->db->query($query)->execute(array_merge(array_values($values), array_values($whereClause)));
    }

    public function delete(string $table, array $whereClause): ResultSetInterface
    {
        $query = "DELETE FROM $table WHERE 1=1 ";

        foreach (array_keys($whereClause) as $column) {

            $query .= "AND $column = ?";
        }

        return $this->db->query($query)->execute($whereClause);
    }

    public function select(array $columns = []): QueryBuilderInterface
    {
        $this->query = "SELECT ";

        if (empty($columns)) {
            $this->query .= "*";
        } else {
            $this->query .= implode(", ", $columns);
        }

        return $this;
    }

    public function from(string $table): QueryBuilderInterface
    {
        $this->table = $table;

        $this->query .= " FROM $table";
        return $this;
    }

    public function where(array $criteria = []): QueryBuilderInterface
    {
        $this->query .= " WHERE 1=1 ";

        foreach (array_keys($criteria) as $column) {

            $this->query .= "AND $column = ?";
        }

        $this->whereClause = array_values($criteria);

        return $this;
    }

    public function orderBy(array $order): QueryBuilderInterface
    {
        if (empty($order) === true) {
            return $this;
        }

        $this->query .= " ORDER BY ";

        if (count(array_filter(array_keys($order), "is_string")) > 0) {
            foreach ($order as $column => $criterion) {

                if ($this->hasColumn($this->table, $column)) {
                    $this->query .= "$column $criterion, ";
                } else {
                    throw new \Exception("Column doesnt exists");
                }
            }
        } else {
            foreach ($order as $column) {
                if ($this->hasColumn($this->table, $column)) {
                    $this->query .= "$column, ";
                } else {
                    throw new \Exception("Column doesnt exists");
                }
            }
        }

        $this->query = rtrim($this->query, ", ");

        return $this;
    }

    public function groupBy(array $columns): QueryBuilderInterface
    {
        $this->query .= " GROUP BY " . implode(", ", $columns);

        return $this;
    }

    public function innerJoin(string $table, array $on): QueryBuilderInterface
    {
        $this->query .= " INNER JOIN $table ON ";
        $this->query .= array_keys($on)[0] . " = " . array_values($on)[0];

        return $this;
    }

    public function leftJoin(string $table, array $on): QueryBuilderInterface
    {
        $this->query .= " LEFT JOIN $table ON ";
        $this->query .= array_keys($on)[0] . " = " . array_values($on)[0];

        return $this;
    }

    public function rightJoin(string $table, array $on): QueryBuilderInterface
    {
        $this->query .= " RIGHT JOIN $table ON ";
        $this->query .= array_keys($on)[0] . " = " . array_values($on)[0];

        return $this;
    }

    public function avg($value): string
    {
        return "AVG($value)";
    }

    public function sum($value): string
    {
        return "SUM($value)";
    }

    public function min($value): string
    {
        return "MIN($value)";
    }

    public function max($value): string
    {
        return "MAX($value)";
    }

    public function count($value): string
    {
        return "COUNT($value)";
    }

    /**
     * Executes the query.
     * After execution, clears the query and the where clause.
     *
     * @param bool $paginate If true, the paginator is called.
     * @param int $elPerPage
     * @return ResultSetInterface
     */
    public function build(bool $paginate = false, int $elPerPage = 10, int $numOfDisplayedPages = 10): ResultSetInterface
    {
        $result = $this->db->query($this->query)->execute($this->whereClause);

        if ($paginate) {
            Paginator::setTotalElements($result->getRowCount());
            Paginator::setElementsPerPage($elPerPage);
            Paginator::setNumOfDisplayedPages($numOfDisplayedPages);
            $this->query .= Paginator::init();
            $result = $this->db->query($this->query)->execute($this->whereClause);
        }

        $this->query = "";
        $this->whereClause = [];

        return $result;
    }

    /**
     * Checks if the table contains the given column.
     * If the table or column have alias,
     * only the full name will be taken.
     *
     * @param string|null $table
     * @param string $column
     * @return bool
     */
    private function hasColumn(?string $table, string $column): bool
    {
        $hasColumn = false;

        if (isset($table)) {

            $tableNameTokens = explode(" ", $table);

            if (count($tableNameTokens) > 1) {
                $table = $tableNameTokens[0];
            }

            $columnNameTokens = explode(".", $column);

            if (count($columnNameTokens) > 1) {
                $column = $columnNameTokens[1];
            }

            $columns = $this->db->query("SHOW COLUMNS FROM $table")->execute()->fetchAll();

            foreach ($columns as $columnInfo) {
                if ($columnInfo->Field == $column) {
                    $hasColumn = true;
                    break;
                }
            }
        }

        return $hasColumn;
    }
}
