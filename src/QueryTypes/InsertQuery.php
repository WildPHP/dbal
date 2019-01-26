<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;


class InsertQuery implements QueryInterface
{
    /**
     * @var string
     */
    private $table;

    /**
     * @var array
     */
    private $values;

    /**
     * @var array
     */
    private $columns;

    /**
     * @var string
     */
    private $valueQuery = '';

    /**
     * InsertQuery constructor.
     * @param string $table
     * @param array $values
     * @throws \WildPHP\Database\DatabaseException
     */
    public function __construct(string $table, array $values)
    {
        $this->setTable($table);
        $this->setValues($values);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return sprintf('INSERT INTO %s (%s) VALUES (%s)',
            $this->getTable(),
            implode(', ', $this->getColumns()),
            $this->getValueQuery());
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * @param array $values
     */
    public function setValues(array $values): void
    {
        $this->columns = QueryHelper::prepareColumnNames(array_keys($values));
        $this->valueQuery = implode(', ', str_split(str_repeat('?', count($this->getValues()))));

        $this->values = $values;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @return string
     */
    public function getValueQuery(): string
    {
        return $this->valueQuery;
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
}