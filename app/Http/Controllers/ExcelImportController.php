<?php

namespace App\Http\Controllers;

use App\Imports\PartsImport; // Ensure this line is present
use Illuminate\Http\Request;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv'
        ]);

        $filePath = $request->file('file')->store('uploads');

        $import = new PartsImport();
        $import->import(storage_path('app/' . $filePath));

        return response()->json(['message' => 'Import successful']);
    }
}
