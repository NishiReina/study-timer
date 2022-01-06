<?php

namespace App\UseCases\ConvertTypes;
// namespaceの宣言

use App\Models\User;
// 必要なモデルのUse

final class ChangeString
{
    public function __invoke($sec)
    {
        $hour = $sec / 3600;
        $min = ($sec % 3600) / 60;
        $sec = $sec % 60;

        $stringTime = sprintf("%02d:%02d:%02d", $hour, $min, $sec);
        return $stringTime;
    }
}