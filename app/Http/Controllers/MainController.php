<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function Index()
    {
        // 今月のシフトを取得し、社員IDと名前を関連付け
        $shifts = Shift::with('employee')  // employee リレーションをロード
        ->whereYear('shift_date', now()->year)  // 現在の年でフィルタリング
        ->whereMonth('shift_date', now()->month)  // 現在の月でフィルタリング
        ->orderBy('start_time')  // 開始時間順に並び替え
        ->get();

        return view('index', compact('shifts'));
    }

    public function getShifts()
    {
        $shifts = Shift::with('employee')
            ->where('shift_type', 25) // 公休や有給を除外
            ->get();

        return response()->json($shifts->map(function ($shift) {
            if ($shift->employee) {
                return [
                    'title' => $shift->employee->name,
                    'start' => $shift->shift_date . 'T' . $shift->start_time,
                    'end' => $shift->shift_date . 'T' . $shift->end_time,
                ];
            } else {
                return [
                    'title' => '未割り当て (' . substr($shift->start_time, 0, 5) . ' - ' . substr($shift->end_time, 0, 5) . ')',
                    'start' => $shift->shift_date . 'T' . $shift->start_time,
                    'end' => $shift->shift_date . 'T' . $shift->end_time,
                ];
            }
        }));
    }

}
