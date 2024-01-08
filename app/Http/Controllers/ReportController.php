<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['user', 'file']);
    
        if ($request->has('file_id')) {
            $fileId = $request->input('file_id');
            $query->where('file_id', $fileId);
        }
    
        $sortBy = $request->input('sort_by', 'time_in');
        $sortType = $request->input('sort_type', 'desc');
    
        $query->orderBy($sortBy, $sortType);
    
        $reports = $query->get();
    
        return view('reports.index', [
            'reports' => $reports,
            'sortBy' => $sortBy,
            'sortType' => $sortType,
        ]);
    }
}