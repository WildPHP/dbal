<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\Providers;

use WildPHP\Database\DatabaseException;
use WildPHP\Database\QueryTypes\DeleteQuery;
use WildPHP\Database\QueryTypes\ExistsQuery;
use WildPHP\Database\QueryTypes\InsertQuery;
use WildPHP\Database\QueryTypes\SelectQuery;
use WildPHP\Database\QueryTypes\UpdateQuery;

abstract class GenericPdoProvider implements ProviderInterface
{
    /**
     * @var \PDO
     */
    protected $pdo;

    /**
     * @var array
     */
    protected $knownTables = ['users', 'channels', 'policies'];

    /**
     * @param SelectQuery $query
     * @return null|array
     * @throws DatabaseException
     */
    public function selectFirst(SelectQuery $query): ?array
    {
        $query->setLimit(1);
        return $this->select($query)[0] ?? null;
    }

    /**
     * @param SelectQuery $query
     * @return array
     * @throws DatabaseException
     */
    public function select(SelectQuery $query): array
    {
        $result = $this->pdo->prepare($query->toString());
        $result->execute(array_values($query->getWhere()));

        return $result->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param ExistsQuery $query
     * @return bool
     * @throws DatabaseException
     */
    public function has(ExistsQuery $query): bool
    {
        $result = $this->pdo->prepare($query->toString());
        $result->execute(array_values($query->getWhere()));
        return $result->fetchColumn() == 1;
    }

    /**
     * @param UpdateQuery $query
     * @return int Number of affected rows
     * @throws DatabaseException
     */
    public function update(UpdateQuery $query): int
    {
        $result = $this->pdo->prepare($query->toString());
        $result->execute(array_merge(array_values($query->getNewValues()), array_values($query->getWhere())));

        return $result->rowCount();
    }

    /**
     * @param InsertQuery $query
     * @return string
     * @throws DatabaseException
     */
    public function insert(InsertQuery $query): string
    {
        $statement = $this->pdo->prepare($query->toString());
        $statement->execute(array_values($query->getValues()));

        return $this->pdo->lastInsertId();
    }

    /**
     * @param DeleteQuery $query
     * @return int Number of affected rows
     * @throws DatabaseException
     */
    public function delete(DeleteQuery $query): int
    {
        $statement = $this->pdo->prepare($query->toString());
        $statement->execute(array_values($query->getWhere()));

        return $statement->rowCount();
    }
}