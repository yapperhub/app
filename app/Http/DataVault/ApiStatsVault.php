<?php

namespace App\Http\DataVault;

use App\Models\ApiStat;

class ApiStatsVault
{
    public function handle(int $userId): array
    {
        $apiStatsArray = [];
        $apiStats = ApiStat::query()->whereBetween('created_at', [
            now()->startOfMonth(),
            now()->endOfMonth(),
        ])->where('user_id', $userId)->get();

        foreach ($apiStats as $apiStat) {
            if (! isset($apiStatsArray[$this->dateFormater($apiStat->created_at)])) {
                $apiStatsArray[$this->dateFormater($apiStat->created_at)] = 1;
            } else {
                $apiStatsArray[$this->dateFormater($apiStat->created_at)] = $apiStatsArray[$this->dateFormater($apiStat->created_at)] + 1;
            }
        }

        return $apiStatsArray;
    }

    public function chart(array $apiStatsArray): array
    {
        return [
            'type' => 'line',
            'data' => [
                'labels' => array_keys($apiStatsArray),
                'datasets' => [
                    [
                        'label' => 'Api Call Stats',
                        'data' => array_values($apiStatsArray),
                    ],
                ],
            ],
        ];
    }

    private function dateFormater($date): string
    {
        return $date->format('F j, Y');
    }
}
