<?php

namespace App\Http\Controllers;

use App\Models\District;
use Illuminate\Http\Request;

class DistrictController extends Controller
{
    public function subAreas(District $district)
    {
        return response()->json($district->subAreas);
    }
}
