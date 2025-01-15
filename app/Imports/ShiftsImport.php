<?php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ShiftsImport implements ToModel
{
    public function model(array $row)
    {

        // 勤務時間のnullをチェック
        $start_time = !empty($row[10]) ? \Carbon\Carbon::parse($row[10])->format('H:i') : null;
        $end_time = !empty($row[12]) ? \Carbon\Carbon::parse($row[12])->format('H:i') : null;

        // 該当する社員IDと日付のデータを検索
        $shift = Shift::where('employee_id', $row[1])
            ->where('shift_date', \Carbon\Carbon::parse($row[2])->format('Y-m-d'))
            ->first();

        if ($shift) {
            // 既存データがある場合は更新
            $shift->update([
                'shift_type' => $row[7],
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            return null; // 更新時は新しいモデルを返さない
        }

        return new Shift([
            'employee_id' => $row[1],  // CSVの社員ID列名を確認して置き換えてください
            'shift_date' => \Carbon\Carbon::parse($row[2])->format('Y-m-d'),  // 日付の形式を適切に変換
            'shift_type' => $row[7],
            'start_time' => $start_time,  // 時刻形式を適切に変換
            'end_time' => $end_time,  // 時刻形式を適切に変換
        ]);
    }
}
