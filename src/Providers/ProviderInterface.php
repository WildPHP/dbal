<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\Providers;

use WildPHP\Database\QueryTypes\DeleteQuery;
use WildPHP\Database\QueryTypes\ExistsQuery;
use WildPHP\Database\QueryTypes\InsertQuery;
use WildPHP\Database\QueryTypes\SelectQuery;
use WildPHP\Database\QueryTypes\UpdateQuery;

/**
 * Interface DatabaseStorageProviderInterface
 * @package WildPHP\Core\Storage\Providers
 */
interface ProviderInterface
{
    /**
     * @param SelectQuery $query
     * @return array
     */
    public function select(SelectQuery $query): array;

    /**
     * @param SelectQuery $query
     * @return array|null
     */
    public function selectFirst(SelectQuery $query): ?array;

    /**
     * @param UpdateQuery $query
     * @return mixed
     */
    public function update(UpdateQuery $query);

    /**
     * @param InsertQuery $query
     * @return string
     */
    public function insert(InsertQuery $query): string;

    /**
     * @param DeleteQuery $query
     * @return mixed
     */
    public function delete(DeleteQuery $query);

    /**
     * @param ExistsQuery $query
     * @return bool
     */
    public function has(ExistsQuery $query): bool;
}