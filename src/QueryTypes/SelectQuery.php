<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;

/**
 * Class SelectQuery
 * @package WildPHP\Database\QueryTypes
 */
class SelectQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $where;

    /**
     * @var array
     */
    private $joins;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var int
     */
    private $limit;

    /**
     * SelectQuery constructor.
     * @param string $table
     * @param array $columns
     * @param array $where
     * @param array $joins
     * @param int $limit
     * @throws \WildPHP\Database\DatabaseException
     */
    public function __construct(
        string $table,
        array $columns = [],
        array $where = [],
        array $joins = [],
        int $limit = -1
    )
    {
        $this->setTable($table);
        $this->setWhere($where);
        $this->setJoins($joins);
        $this->setColumns($columns);
        $this->setLimit($limit);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $limitSubQuery = $this->getLimit() > 0 ? 'LIMIT ' . $this->getLimit() : '';

        /** @noinspection SyntaxError */
        return sprintf('SELECT %s FROM %s %s %s %s',
            implode(', ', $this->getColumns()),
            $this->getTable(),
            $this->getJoins(),
            $this->getWhere(),
            $limitSubQuery
        );
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return !empty($this->columns) ? $this->columns : ['*'];
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns): void
    {
        $this->columns = QueryHelper::prepareColumnNames($columns);
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * @param string $table
     * @throws \WildPHP\Database\DatabaseException
     */
    public function setTable(string $table): void
    {
        $this->table = QueryHelper::prepareTableName($table);
    }

    /**
     * @return array
     */
    public function getJoins(): array
    {
        return $this->joins;
    }

    /**
     * @param array $joins
     * @throws \WildPHP\Database\DatabaseException
     */
    public function setJoins(array $joins): void
    {
        $this->joins = QueryHelper::prepareJoinStatement($joins);
    }

    /**
     * @return array
     */
    public function getWhere(): array
    {
        return $this->where;
    }

    /**
     * @param array $where
     */
    public function setWhere(array $where): void
    {
        $this->where = QueryHelper::prepareWhereStatement($where);
    }
}