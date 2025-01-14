<?php

namespace App\Http\Controllers;

use App\Imports\ShiftsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ShiftController extends Controller
{
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        Excel::import(new ShiftsImport, $request->file('file'));

        return redirect()->back()->with('success', 'シフトデータがインポートされました');
    }
}
