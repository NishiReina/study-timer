<?php

namespace App\UseCases\Calculation;
// namespaceの宣言

use App\Models\User;
// 必要なモデルのUse

use App\UseCases\ConvertTypes\ChangeSec;
use App\UseCases\ConvertTypes\ChangeString;

final class BestDay
{
    public function __invoke($diaries, ChangeSec $changeSec, ChangeString $changeString)
    {
        $bestTime = 0;
        $bestDay = "";
        foreach($diaries as $diary){
            $timeTmp = $changeSec($diary->time);
            if ($timeTmp >= $bestTime){
                $bestTime = $timeTmp;
                $bestDay = $diary->created_at->format('Y-m-d');
            }
        }

        $bestStringTime = $changeString($bestTime);

        return [$bestDay, $bestStringTime];
    }
}