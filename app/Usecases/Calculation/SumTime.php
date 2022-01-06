<?php

namespace App\UseCases\Calculation;
// namespaceの宣言

use App\Models\User;
use App\UseCases\ConvertTypes\ChangeSec;
use App\UseCases\ConvertTypes\ChangeString;

// MEMO:ここでちゃんとユースケース呼び出してやれているなら、diaryControllerの各アクションの引数に入れる必要ない気がする。全然最初と違って、ユースケース同士でよぶのもありかも？

final class SumTime
{
    public function __invoke($diaries, ChangeSec $changeSec, ChangeString $changeString)
    {
        $totalSec = 0;
        foreach($diaries as $diary){
            $totalSec += $changeSec($diary->time);
        }
        
        $sumTime = $changeString($totalSec);
        return $sumTime;
    }
}