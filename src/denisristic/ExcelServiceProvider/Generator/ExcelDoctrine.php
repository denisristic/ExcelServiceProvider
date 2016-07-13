<?php

namespace denisristic\ExcelServiceProvider\Generator;

use Doctrine\DBAL\Connection;
use denisristic\ExcelServiceProvider\Exception\InvalidTablenameException;

class ExcelDoctrine extends Excel
{
    private $doctrine = null;

    public function __construct(Connection $doctrine = null)
    {
        $this->doctrine = $doctrine;
    }

    public function generateXLSFromTable($tableName)
    {

        // First let's get the current database
        $databaseName = $this->doctrine->fetchColumn('SELECT DATABASE()');

        // Get a list of the headers, and if there are none throw an exception
        $headers = $this->doctrine->fetchAll('
          SELECT COLUMN_NAME
          FROM INFORMATION_SCHEMA.COLUMNS
          WHERE TABLE_SCHEMA=?
          AND TABLE_NAME=?
        ', array($databaseName, $tableName));
        if (sizeof($headers) === 0) {
            throw new InvalidTablenameException('This is not a valid table name');
        }

        $results = $this->doctrine->fetchAll("SELECT * FROM $tableName ORDER BY id ASC");

        $headers = array_map(
            function ($value) { return ucwords($value); }, array_column($headers, 'COLUMN_NAME')
        );

        return $this->generateXLS($headers, $results);
    }
}
