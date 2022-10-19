<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Emoji;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmojiChart extends BaseChart
{
    public function __construct()
    {
        $this->middlewares = ['web'];
    }
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $startDate = date("Y-m-d", strtotime($request['startdate']));
        $endDate = date("Y-m-d", strtotime($request['enddate']));
        $emoji_id = $request['emoji_id'];
        $lang     = $request['lang'];

        $feeling = Emoji::withCount(['feelings' => function($q) use($startDate, $endDate){
            return $q->where('feeling_emoji.user_id', Auth::id())
                    ->whereBetween('feeling_emoji.created_at', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }])->where('id', $emoji_id)
           ->get();

        $feelinTotal = Emoji::withCount(['feelings' => function($q) use($startDate, $endDate){
            return $q->where('feeling_emoji.user_id', Auth::id())
                    ->whereBetween('feeling_emoji.created_at', [$startDate.' 00:00:00',$endDate.' 23:59:59']);
        }])->get();
        $total = 0;
        foreach($feelinTotal as $feelt)
        {
            $total += $feelt->feelings_count;
        }

        $types = $feeling->map(function($feel) use ($lang){
            $type = 'type_' . $lang;
            return $feel->$type;
        })->toArray();

        $counts = $feeling->map(function($feel){
            return $feel->feelings_count;
        })->toArray();

        $extras = $feeling->map(function($feeling){
            return  ["class" => $feeling->css_class,
                     "count" => $feeling->feelings_count,
                     "color" => $feeling->color, 
                     "type_ar" => $feeling->type_ar,
                     "type_en" => $feeling->type_en,
                     "type_de" => $feeling->type_de,
                     "type_es" => $feeling->type_es,
                     "type_fr" => $feeling->type_fr,
                     "type_it" => $feeling->type_it,
                     "type_tr" => $feeling->type_tr,
                     "type_hi" => $feeling->type_hi,
                     "type_zh" => $feeling->type_zh,
                     'type_ur' => $feeling->type_ur,
                     'type_fa' => $feeling->type_fa,
                     'type_bn' => $feeling->type_bn,
                     'type_id' => $feeling->type_id,
                     'type_ru' => $feeling->type_ru,
                     'type_pt' => $feeling->type_pt,
                     'type_ko' => $feeling->type_ko,
                     'type_ja' => $feeling->type_ja,
                     'type_ms' => $feeling->type_ms,
                     "category" => $feeling->category];
        })->toArray();
        
        return Chartisan::build()
            ->labels($types)
            ->dataset('Feeling', $counts)
            ->extra(['total' => $total, 'data' => $extras]);
    }
}