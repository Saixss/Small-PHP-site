<?php


namespace database\ORM\Repository;


use core\Exception\RouteException;
use database\ORM\QueryBuilder\QueryBuilderInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected QueryBuilderInterface $queryBuilder;

    private string $entity;

    protected string $table;

    private string $primaryKey;

    private array $relatedSingularRepositories;

    private array $relatedPluralRepositories;


    public function __construct(QueryBuilderInterface $queryBuilder, string $entity, string $table, string $primaryKey, array $relatedSingularRepositories = [], array $relatedPluralRepositories = [])
    {
        $this->queryBuilder = $queryBuilder;
        $this->entity = $entity;
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->relatedSingularRepositories = $relatedSingularRepositories;
        $this->relatedPluralRepositories = $relatedPluralRepositories;
    }

    /**
     * @throws RouteException
     */
    public function findAll(array $orderBy = [], bool $populateNavigationProp = true, array $navigationPropOrderBy = []): \Generator
    {
        $builder = $this->queryBuilder->select()->from($this->table);

        if (empty($orderBy) === false) {
            $builder = $builder->orderBy($orderBy);
        }

        $results = $builder->build()->fetchAll($this->entity);

        $this->hasEntity($results);

        foreach ($results as $entity) {
            if ($populateNavigationProp) {
                yield $this->populateNavigationProperties($entity, $navigationPropOrderBy);
            } else {
                yield $entity;
            }
        }
    }

    public function findBy(array $where, array $orderBy = [],  array $navigationPropOrderBy = []): \Generator
    {
        $builder = $this
            ->queryBuilder
            ->select()
            ->from($this->table)
            ->where($where);

        if (empty($orderBy) === false) {
            $builder = $builder->orderBy($orderBy);
        }

        $results = $builder->build()->fetchAll($this->entity);

        $this->hasEntity($results);


        foreach ($results as $entity) {
            yield $this->populateNavigationProperties($entity, $navigationPropOrderBy);
        }
    }

    /**
     * @throws RouteException
     */
    public function findOne(array $where, bool $populateNavigationProp = true, array $navigationPropOrderBy = [])
    {
        $result = $this
            ->queryBuilder
            ->select()
            ->from($this->table)
            ->where($where)
            ->build()
            ->fetch($this->entity);

        $this->hasEntity($result);

        if ($populateNavigationProp) {
            return $this->populateNavigationProperties($result, $navigationPropOrderBy);
        } else {
            return $result;
        }
    }

    protected function populateNavigationProperties($entity, array $orderBy = [])
    {
        foreach ($this->relatedSingularRepositories as $repository) {

            $class = "\src\Repository\\" . ucfirst($repository)  . "\\" . ucfirst($repository) . "Repository";
            $repositoryObject = new $class($this->queryBuilder);

            $foreignKey = $repository . "Id";

            $setter = "set" . ucfirst($repository);
            $getter = "get" . ucfirst($foreignKey);

            $findOne = "findOne";

            $relatedObject = $repositoryObject->${$findOne}([$repositoryObject->getPrimaryKey() => $entity->$getter()]);

            $entity->$setter($relatedObject);
        }

        foreach ($this->relatedPluralRepositories as $repository) {

            $class = "\src\Repository\\" . ucfirst(rtrim($repository, "s"))  . "\\" . ucfirst(rtrim($repository, "s")) . "Repository";
            $repositoryObject = new $class($this->queryBuilder);

            if (str_ends_with($this->table, "ies")) {
                $foreignKey = rtrim($this->table, "ies") . "y_id";
            } else {
                $foreignKey = rtrim($this->table, "s") . "_id";
            }

            $setter = "set" . ucfirst($repository);
            $getter = "get" . ucfirst($this->primaryKey);

            $findBy = "findBy";

            /**
             * @var array Holds the order by values for each related repository
             */
            $orderByForTable = [];

            foreach ($orderBy as $table => $order) {
                if ($table === $repositoryObject->getTable()) {
                    $orderByForTable = $order;
                }
            }

            $relatedObject = $repositoryObject->${$findBy}([$foreignKey => $entity->$getter()], $orderByForTable, $orderBy);

            $entity->$setter($relatedObject);
        }

        return $entity;
    }

    /**
     * @throws RouteException
     */
    protected function hasEntity($entity): void
    {
        if (isset($entity) === false) {
            throw new RouteException();
        }
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function getTable(): string
    {
        return $this->table;
    }
}