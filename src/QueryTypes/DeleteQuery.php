<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;


class DeleteQuery implements QueryInterface
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
     * DeleteQuery constructor.
     * @param string $table
     * @param array $where
     */
    public function __construct(string $table, array $where)
    {
        $this->table = $table;
        $this->where = $where;
    }

    /**
     * @return string
     * @throws \WildPHP\Database\DatabaseException
     */
    public function toString(): string
    {
        /** @noinspection SyntaxError */
        return sprintf('DELETE FROM %s %s',
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
     */
    public function setTable(string $table): void
    {
        $this->table = $table;
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
        $this->where = $where;
    }
}