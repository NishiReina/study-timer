<?php

namespace App\UseCases\ConvertTypes;
// namespaceの宣言

use App\Models\User;
// 必要なモデルのUse

final class ChangeSec
{   
    public function __invoke($stringTime)
    {
        $timeData = explode(":", $stringTime);

        $sumHour = (int)$timeData[0];
        $sumMin = (int)$timeData[1];
        $sumSec = (int)$timeData[2];

        $totalSec = ($sumHour * 60 * 60) + ($sumMin * 60) + $sumSec;
        return $totalSec;
    }
}