<?php
/**
 * Copyright 2019 The WildPHP Team
 *
 * You should have received a copy of the MIT license with the project.
 * See the LICENSE file for more information.
 */

namespace WildPHP\Database\Providers;

use PDO;
use WildPHP\Database\DatabaseException;

class SQLiteProvider extends GenericPdoProvider
{
    /**
     * SQLiteStorageProvider constructor.
     * @param string $databaseFile
     * @throws DatabaseException
     */
    public function __construct(string $databaseFile)
    {
        if (!file_exists($databaseFile)) {
            throw new DatabaseException('The given database file does not exist');
        }

        $this->pdo = new \PDO('sqlite:' . $databaseFile);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}