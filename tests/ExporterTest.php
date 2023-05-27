<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class ExporterTest extends TestCase
{
    public function test() {
        $filePath = 'asd.xml';
        $exporter = new \Exchangehunter\RatesExportPhp\Exporter($filePath);
        $exporter->add('ASD', 'ZXC', '1', '2', '300', '10 USD', '100 USD');
        $exporter->add('ASD', 'ZXC1', '1', '2', '300', '10 USD', '100 USD', 'KYIV', true);
        $exporter->add('ASD', 'ZXC2', '1', '2', '300', '10 USD', '100 USD', 'KYIV', true, true);
        $exporter->save();

        $this->assertFileEquals(__DIR__ . '/fixtures/export.xml', $filePath);
        unlink($filePath);
    }
}
