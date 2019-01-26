<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\QueryTypes;

use WildPHP\Database\DatabaseException;

/**
 * Class QueryHelper
 * @package WildPHP\Database\QueryTypes
 */
class QueryHelper
{
    /**
     * @var array
     */
    private static $knownTables = [];

    /**
     * @param array $columns
     * @return array
     */
    public static function prepareColumnNames(array $columns): array
    {
        if (empty($columns)) {
            return ['*'];
        }

        foreach ($columns as $key => $column) {
            $columns[$key] = self::prepareColumnName($column);
        }

        return $columns;
    }

    /**
     * @param string $column
     * @param bool $enforceQuotes
     * @return string
     */
    public static function prepareColumnName(string $column, bool $enforceQuotes = false): string
    {
        if (!$enforceQuotes && !strpos($column, '"')) {
            return $column;
        }

        return '"' . addcslashes($column, '"') . '"';

    }

    /**
     * @param array $joins
     * @return string
     * @throws DatabaseException()
     */
    public static function prepareJoinStatement(array $joins): string
    {
        if (empty($joins)) {
            return '';
        }

        $statements = [];
        foreach ($joins as $table => $joinOn) {
            $statements[] = sprintf('JOIN %s ON %s',
                self::prepareTableName($table),
                $joinOn);
        }

        return implode(' ', $statements);
    }

    /**
     * @param string $table
     * @return string
     * @throws DatabaseException()
     */
    public static function prepareTableName(string $table): string
    {
        if (!in_array($table, self::$knownTables, true)) {
            throw new DatabaseException('Table is not in the known tables list.');
        }

        return $table;
    }

    /**
     * @param array $where
     * @return string
     */
    public static function prepareWhereStatement(array $where): string
    {
        if (empty($where)) {
            return '';
        }

        $statements = [];
        foreach ($where as $column => $value) {
            $statements[] = sprintf('%s = ?', $column);
        }

        return 'WHERE ' . implode(' AND ', $statements);
    }

    /**
     * @param string $table
     */
    public static function addKnownTableName(string $table): void
    {
        if (!in_array($table, self::$knownTables, true)) {
            self::$knownTables[] = $table;
        }
    }
}