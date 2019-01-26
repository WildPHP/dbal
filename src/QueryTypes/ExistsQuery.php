<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;


class ExistsQuery implements QueryInterface
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
     * ExistsQuery constructor.
     * @param string $table
     * @param array $where
     * @throws \WildPHP\Database\DatabaseException
     */
    public function __construct(string $table, array $where)
    {
        $this->setTable($table);
        $this->setWhere($where);
    }

    /**
     * @return string
     * @throws \WildPHP\Database\DatabaseException
     */
    public function toString(): string
    {
        return sprintf('SELECT EXISTS(SELECT 1 FROM %s %s)',
            QueryHelper::prepareTableName($this->getTable()),
            QueryHelper::prepareWhereStatement($this->getWhere())
        );
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