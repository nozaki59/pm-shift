<?php

namespace App\Imports;

use App\Models\Shift;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ShiftsImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        // 1行目を無視してインポートするため、実際のデータ行を処理
        $start_time = !empty($row[10]) ? \Carbon\Carbon::parse($row[10])->format('H:i') : '00:00';
        $end_time = !empty($row[12]) ? \Carbon\Carbon::parse($row[12])->format('H:i') : '00:00';

        // 該当する社員IDと日付のデータを検索
        $shift = Shift::where('employee_id', $row[1])
            ->where('shift_date', \Carbon\Carbon::parse($row[2])->format('Y-m-d'))
            ->first();

        if ($shift) {
            // 既存データがある場合は更新
            $shift->update([
                'shift_type' => $row[5],
                'start_time' => $start_time,
                'end_time' => $end_time,
            ]);
            return null; // 更新時は新しいモデルを返さない
        }

        return new Shift([
            'employee_id' => $row[1],
            'shift_date' => \Carbon\Carbon::parse($row[2])->format('Y-m-d'),
            'shift_type' => $row[5],
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);
    }

    // 1行目をスキップ
    public function startRow(): int
    {
        return 2;  // 最初の行をスキップする
    }
}

