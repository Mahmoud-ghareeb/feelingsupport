<?php

namespace App\Http\Controllers\Front;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Http\Controllers\Controller;
use App\Models\Emoji;
use App\Models\Feeling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use function GuzzleHttp\Promise\each;

class ChartController extends Controller
{
    public function index()
    {
        return view('front.charts');
    }

    public function compare()
    {
        $emojis = Emoji::orderBy('raw_order')->get();
        return view('front.compare', compact('emojis'));
    }

    public function emoji()
    {
        $emojis = Emoji::orderBy('raw_order')->get();
        return view('front.emoji', compact('emojis'));
    }

    public function test()
    {
        $startDate = date("Y-m-d", strtotime('07/7/2022'));
        $endDate = date("Y-m-d", strtotime('07/7/2022'));

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

        return $totalPositive . ' ' . $totalNegative . ' ' . $total;
    }

    public function egabi()
    {
        return view('front.egabi');
    }
}

