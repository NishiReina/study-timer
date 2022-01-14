<?php

namespace App\UseCases\Calculation;
// namespaceの宣言

use App\Models\User;
use App\Models\Diary;
use Carbon\Carbon;
use App\UseCases\ConvertTypes\ChangeSec;
use App\UseCases\ConvertTypes\ChangeString;
use App\UseCases\Calculation\SumTime;

// 必要なモデルのUse

final class BestMonth
{
    public function __invoke(SumTime $sumTime, ChangeSec $changeSec, ChangeString $changeString)
    {
        $now = Carbon::now();

        // ここから 「これまでの日記」のリストの表示
        $diary = Diary::orderBy('created_at')->first();
        // dd(diary);
        $from = $diary->created_at ?? null;//null許容
        $monthList = [];
        $firstMonth = $from == !null ? $from->copy() : null ;//memo:firstMonthとかの方がわかりやすくない？
        // $ls->settings([
        //     'monthOverflow' => false
        // ]);
        array_push($monthList, $firstMonth);
        //MEMO:whileで1を指定するならdo~whileのほうがいい気がする
        if ($firstMonth == null) return ;
        while(($firstMonth->month != $now->month) || ($firstMonth->year != $now->year)){
            // if ($firstMonth == null) return ;
            // if (($ls->month == $now->month) && ($ls->year == $now->year)){//MEMO:whileの条件式部分はこのまま&&で繋いで条件にしたらダメなの？
            //     break;
            // }
            
            $ls = $firstMonth->addMonth();
            // ls->copy()にしないと、lsが何度も上書きされ、pushされてしまう。ずっと参照が起きてしまうので、copy()
            array_push($monthList, $firstMonth->copy());
        }
        // ここまで 「これまでの日記」のリストの表示

        $bestSum = 0;
        $sum = "";
        foreach ($monthList as $mls){
            $diaries = Diary::where('created_at', 'like', $mls->format('Y-m').'%')->orderBy('created_at')->get();
            $sum = $sumTime($diaries, $changeSec, $changeString);
            $tmpSum = $changeSec($sum);
            $bestSum = $tmpSum;
            if($tmpSum >= $bestSum){
                $bestSum = $tmpSum;
                $bestMonth = $mls->format('Y-m');
            }
        }
        
        $bestSum = $changeString($bestSum);
        return [$bestMonth, $bestSum];
    }
}