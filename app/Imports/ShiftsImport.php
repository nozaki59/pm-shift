<?php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftsImport implements ToModel
{
    public function model(array $row)
    {
        return new Shift([
            'employee_id' => $row[1],  // CSVの社員ID列名を確認して置き換えてください
            'shift_date' => \Carbon\Carbon::parse($row[2])->format('Y-m-d'),  // 日付の形式を適切に変換
            'shift_type' => $row[7],
            'start_time' => \Carbon\Carbon::parse($row[10])->format('H:i'),  // 時刻形式を適切に変換
            'end_time' => \Carbon\Carbon::parse($row[12])->format('H:i'),  // 時刻形式を適切に変換
        ]);
    }
}
