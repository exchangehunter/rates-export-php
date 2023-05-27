# Rates export PHP
This library helps you to generate rates export
file for exchangers monitors.

## Installation
```shell
composer require exchangehunter/rates-export-php
```

## Usage:
```php
// Create exporter instance with export file path
$filePath = 'path/export.xml';
$exporter = new \Exchangehunter\RatesExportPhp\Exporter($filePath);
// Add some rates for export
$exporter->add('BTC', 'USDT', 1, 25000, 10, 0.01, 1);
// Save file
$exporter->save();
```