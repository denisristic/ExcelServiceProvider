# Silex ExcelServiceProvider

## Introduction

This service provider for Silex allows you to quickly generate Excel (*.xls) spreadsheets. Either pass in a query result
set, and a list of headers, or use the Doctrine functionality to convert a table to a spreadsheet.

This project has ben ported from https://github.com/deanc/ExcelServiceProvider

## Installation

Require the provider using `composer`:

        composer require denisristic/ExcelServiceProvider
        
Register the provider in your application somewhere:

        $app->register(new \denisristic\ExcelServiceProvider\Provider\ExcelServiceProvider());

## Usage

Generate a spreadsheet from a table (if you are using the `DoctrineServiceProvider`):

```php
        $excel = $app['excel']->generateXLSFromTable('tableName');
```        

Generate a spreadsheet manually:

```php
        $headers = array('ID', 'Name', 'Created');
        $data = array(
                0 => array('id' => 1, 'name' => 'Bill Gates', 'created' => '2015-01-01 00:00'),
                1 => array('id' => 2, 'name' => 'Steve Jobs', 'created' => '2015-01-02 00:00'),
                2 => array('id' => 3, 'name' => 'Bill Murray', 'created' => '2015-01-03 00:00')
        );

        $excel = $app['excel']->generateXLS($headers, $results);
```
        
Forcing a download of the spreadsheet:

```php
        $controllers->get('/download', function () use($app) {
        
            $excel = $app['excel']->generateXLSFromTable('entry');

            $xlsName = 'entries-' . date('Y-m-dhis') . '.xls';
            $response = new Response($excel);
            $response->headers->add(array(
                'Content-Type' => 'application/vns.ms-excel'
                ,'Content-Disposition' => 'inline; filename="' . $xlsName . '"'
                ,'Pragma' => 'no-cache'
                ,'Expired' => 0
            ));
            return $response;
                
        })->bind('download');
```