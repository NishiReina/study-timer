<?php

namespace App\UseCases\Calculation;
// namespaceの宣言

use App\Models\User;
use App\Models\Diary;
// 必要なモデルのUse

use App\UseCases\ConvertTypes\ChangeSec;
use App\UseCases\ConvertTypes\ChangeString;
use App\UseCases\Calculation\SumTime;

final class AvgWeekTime
{
    public function __invoke($month, SumTime $sumTime, ChangeSec $changeSec, ChangeString $changeString)
    {
        $diaries = Diary::where('created_at', 'like', $month.'%')->orderBy('created_at', 'DESC')->take(7)->get();
        $num = $diaries->count();
        $day7 = $sumTime($diaries, $changeSec, $changeString);

        $day7 = $changeSec($day7); //divisionByZero回避
        if($num < 7) {
            $avgWeek = $day7;
        } else {
            $avgWeek = $day7 / $num;
        }

        $avgWeek = $changeString($avgWeek);

        return $avgWeek;
    }
}