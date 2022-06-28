<?php


namespace database;


class PDODatabase implements DatabaseInterface
{
    /**
     * @var \PDO
     */
    private \PDO $pdo;

    /**
     * Initializes PDO object in the constructor.
     *
     * PDODatabase constructor.
     */
    public function __construct()
    {
        $dbParams = parse_ini_file("config\db.ini");
        $pdo = new \PDO($dbParams["dsn"], $dbParams["user"], $dbParams["password"], [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        $this->pdo = $pdo;
    }

    /**
     * @param string $query
     * @return PreparedStatementInterface
     */
    public function query(string $query) : PreparedStatementInterface
    {
        $stm = $this->pdo->prepare($query);

        return new PDOPreparedStatement($stm);
    }

    /**
     * Removes underscores from column names.
     * Use this function when the pod fetch mode is PDO::FETCH_OBJECT.
     * Not needed with fetch mode PDO::FETCH_ASSOC and data binder.
     *
     * @param string $query
     * @return string
     */
    private function nameSelectColumns(string $query): string
    {
        $queryBeforeFrom = explode("FROM", $query)[0];

        $queryArr = explode(", ", $queryBeforeFrom);
        $queryArrFiltered = $queryArr;

        for ($i = 0; $i < count($queryArrFiltered); $i++) {

            if (str_contains($queryArrFiltered[$i], "_")) {

                $exactColumn = explode("_", $queryArrFiltered[$i]);
                $columnAs = "";

                if ($i === count($queryArrFiltered) - 1) {

                    $exactColumn[count($exactColumn) - 1] = explode(" ", $exactColumn[count($exactColumn) - 1])[0];
                }

                if ($i === 0) {
                    $exactColumn[0] = explode(" ", $exactColumn[0])[count(explode(" ", $exactColumn[0])) - 1];
                }

                if (str_contains($exactColumn[0], ".")) {

                    $exactColumn[0] = explode(".", $exactColumn[0])[1];
                }

                for ($j = 0; $j < count($exactColumn) - 1; $j++) {
                    if (count($exactColumn) > 2) {
                        if ($j > 0) {
                            $columnAs .= ucfirst($exactColumn[$j + 1]);
                        } else {
                            $columnAs = $exactColumn[$j] . ucfirst($exactColumn[$j + 1]);
                        }
                    } else {
                        $columnAs = $exactColumn[$j] . ucfirst($exactColumn[$j + 1]);
                    }
                }

                if ($i === count($queryArrFiltered) - 1) {
                    $exactColumn = implode("_", $exactColumn);
                    $queryArrFiltered[$i] = str_replace($exactColumn, $exactColumn . " AS " . $columnAs, $queryArrFiltered[$i]);
                    continue;
                }

                $queryArrFiltered[$i] = $queryArrFiltered[$i] . " AS " . $columnAs;
            }
        }

        return implode(", ", $queryArrFiltered) . " FROM " . explode("FROM", $query)[1];
    }
}