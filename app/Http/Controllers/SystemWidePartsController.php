<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemWideParts;
use Illuminate\Http\JsonResponse;

class SystemWidePartsController extends Controller
{
    public function index(): JsonResponse
    {
        
        $parts = SystemWideParts::with(['manufacturer', 'partType'])->get();

        // Return the parts as a JSON response
        return response()->json($parts);
    }
}
