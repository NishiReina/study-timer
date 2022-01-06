<?php

namespace App\UseCases\Calculation;
// namespaceの宣言

use App\Models\User;
// 必要なモデルのUse
use App\UseCases\ConvertTypes\ChangeSec;
use App\UseCases\ConvertTypes\ChangeString;

final class CompareTime
{
    public function __invoke($lastDiaries, $diaries, ChangeSec $changeSec, ChangeString $changeString)
    {
        // timeカラムが文字列なので、時：分：秒を分割して取り出す。

        $lastTotalSec = 0;
        foreach($lastDiaries as $lastDiary){
            $lastTotalSec += $changeSec($lastDiary->time);
        }

        $totalSec = 0;
        foreach($diaries as $diary){
            $totalSec += $changeSec($diary->time);
        }

        // // 先月（先週）と今月（今週）の勉強時間の差を計算
        $diffSec = $totalSec - $lastTotalSec;

        // ○時間○分○秒の形式に戻す。
        if ($diffSec < 0){
            $diffSec = -1 * $diffSec;
            $diffStringSec = $changeString($diffSec);
        }
        $diffStringSec = $changeString($diffSec);

        if( $diffSec > 0 ){
            $compare = sprintf("%s増加", $diffStringSec);
        }else if( $diffSec < 0 ){
            $compare = sprintf("%s減少", $diffStringSec);
        }else{
            $compare = "同じ";
        }

        return $compare;
    }
}
