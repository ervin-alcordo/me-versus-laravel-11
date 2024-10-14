<?php

namespace App\Imports;

use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class PartsImport
{
    public function import($filePath)
    {
        // Load the spreadsheet
        $spreadsheet = IOFactory::load($filePath);
        $worksheet = $spreadsheet->getActiveSheet();

        foreach ($worksheet->getRowIterator() as $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This will include empty cells

            $data = [];
            foreach ($cellIterator as $cell) {
                $data[] = $cell->getValue();
            }

            // Assuming columns are in order: Active, Part Type, Manufacturer, Model Number, List Price
            DB::table('system_wide_parts')->insert([
                'active' => $data[0],
                'part_type_id' => $this->getPartTypeId($data[1]), // Fetch Part Type ID
                'manufacturer_id' => $this->getManufacturerId($data[2]), // Fetch Manufacturer ID
                'model_number' => $data[3],
                'list_price' => $data[4],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function getPartTypeId($partTypeName)
    {
        // Logic to fetch Part Type ID from the part_type table
        return DB::table('part_type')->where('name', $partTypeName)->value('id');
    }

    private function getManufacturerId($manufacturerName)
    {
        // Logic to fetch Manufacturer ID from the manufacturer table
        return DB::table('manufacturer')->where('name', $manufacturerName)->value('id');
    }
}
