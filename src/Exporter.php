<?php declare(strict_types=1);

namespace Exchangehunter\RatesExportPhp;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemWriter;
use League\Flysystem\Local\LocalFilesystemAdapter;

class Exporter
{
    private string $buffer = '';

    private string $filePath;

    private Filesystem $filesystem;

    public function __construct(string $filePath, ?FilesystemWriter $filesystem = null)
    {
        $this->filePath = $filePath;
        $this->filesystem = $filesystem ?? new Filesystem(new LocalFilesystemAdapter(getcwd()));

        $this->reset();
    }

    private function reset(): void
    {
        $this->buffer = '<?xml version="1.0" encoding="UTF-8"?><rates>';
    }

    public function add(
        string $fromCurrency,
        string $toCurrency,
        string $inAmount,
        string $outAmount,
        string $stockAmount,
        string $minAmount,
        string $maxAmount,
        string $city = '',
        bool $isManual = false,
        bool $needCardVerification = false,
    ): void {
        $this->buffer .= '<item>';
        $this->buffer .= '<from>' . $fromCurrency . '</from>';
        $this->buffer .= '<to>' . $toCurrency . '</to>';
        $this->buffer .= '<in>' . $inAmount . '</in>';
        $this->buffer .= '<out>' . $outAmount . '</out>';
        $this->buffer .= '<amount>' . $stockAmount . '</amount>';
        $this->buffer .= '<minamount>' . $minAmount . '</minamount>';
        $this->buffer .= '<maxamount>' . $maxAmount . '</maxamount>';
        if ($city !== '') {
            $this->buffer .= '<city>' . $city . '</city>';
        }
        $params = [];
        if ($isManual) {
            $params[] = 'manual';
        }
        if ($needCardVerification) {
            $params[] = 'cardverify';
        }
        if ($params !== []) {
            $this->buffer .= '<param>' . implode(', ', $params) . '</param>';
        }
        $this->buffer .= '</item>';
    }

    public function save(): void
    {
        $this->buffer .= '</rates>';
        $this->filesystem->write($this->filePath, $this->buffer);
        $this->reset();
    }
}