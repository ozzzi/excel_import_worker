<?php

namespace App\Service;

use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Entity\Product;

class ExcelParser
{
    private $setting;

    private $file;

    public function __construct(array $setting, string $file)
    {
        $this->setting = $setting;
        $this->file = $file;
    }

    public function parse()
    {
        $reader = IOFactory::createReaderForFile($this->file);
        $spreadsheet = $reader->load($this->file);
        $workSheet = $spreadsheet->getActiveSheet();
        $lines = $workSheet->toArray(null, true, true, true);

        $row = 1;

        foreach ($lines as $line) {
            if ($row <= 1) {
                $row++;
                continue;
            }

            $category = $workSheet->getCell($this->setting['category'] . $row)->getFormattedValue();
            $name = $workSheet->getCell($this->setting['name'] . $row)->getFormattedValue();
            $model = $workSheet->getCell($this->setting['model'] . $row)->getFormattedValue();
            $price = $workSheet->getCell($this->setting['price'] . $row)->getCalculatedValue();
            $quantity = $workSheet->getCell($this->setting['quantity'] . $row)->getCalculatedValue();
            $manufacturer = $workSheet->getCell($this->setting['manufacturer'] . $row)->getFormattedValue();
            $description = $workSheet->getCell($this->setting['description'] . $row)->getFormattedValue();

            $row++;

            yield new Product(
                $category,
                $name,
                $model,
                $price,
                $quantity,
                $manufacturer,
                $description
            );
        }
    }
}