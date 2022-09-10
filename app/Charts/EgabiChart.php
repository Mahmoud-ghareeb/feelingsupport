<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Emoji;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EgabiChart extends BaseChart
{
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $startDate = date("Y-m-d", strtotime($request['startdate']));
        $endDate = date("Y-m-d", strtotime($request['enddate']));
        $lang     = $request['lang'];

        $feelinTotal = Emoji::withCount(['feelings' => function($q) use($startDate, $endDate){
            return $q->where('feeling_emoji.user_id', Auth::id())
                    ->whereBetween('feeling_emoji.created_at', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }])->get();

        $total = 0;
        $totalPositive = 0;
        $totalNegative = 0;

        foreach($feelinTotal as $feelt)
        {
            $total += $feelt->feelings_count;
            if($feelt->category == 'positive')
            {
                $totalPositive += $feelt->feelings_count;
            }else
            {
                $totalNegative += $feelt->feelings_count;
            }
             
        }
        $fword = __('messages.positive', [], $lang);
        $sword = __('messages.negative', [], $lang); 

        return Chartisan::build()
            ->labels([$fword, $sword])
            ->dataset('Feeling', [$totalPositive, $totalNegative]);
    }
}