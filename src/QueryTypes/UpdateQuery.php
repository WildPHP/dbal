<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;


class UpdateQuery implements QueryInterface
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
    private $newValues;

    /**
     * @var string[]
     */
    private $setQueryPieces = [];

    /**
     * UpdateQuery constructor.
     * @param string $table
     * @param array $where
     * @param array $newValues
     * @throws \WildPHP\Database\DatabaseException
     */
    public function __construct(string $table, array $where, array $newValues)
    {
        $this->setTable($table);
        $this->setWhere($where);
        $this->setNewValues($newValues);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        /** @noinspection SyntaxError */
        return sprintf('UPDATE %s SET %s %s',
            $this->getTable(),
            implode(', ', $this->setQueryPieces),
            $this->getWhere()
        );
    }

    /**
     * @return array
     */
    public function getNewValues(): array
    {
        return $this->newValues;
    }

    /**
     * @param array $newValues
     */
    public function setNewValues(array $newValues): void
    {
        $setQuery = [];
        foreach ($this->getNewValues() as $column => $value) {
            $setQuery[] = QueryHelper::prepareColumnName($column) . ' = ?';
        }
        $this->setQueryPieces = $setQuery;

        $this->newValues = $newValues;
    }

    /**
     * @return string[]
     */
    public function getSetQueryPieces(): array
    {
        return $this->setQueryPieces;
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