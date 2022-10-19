<?php

declare(strict_types = 1);

namespace App\Charts;

use App\Models\Emoji;
use Chartisan\PHP\Chartisan;
use ConsoleTVs\Charts\BaseChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CompareChart extends BaseChart
{
    public function __construct()
    {
        $this->middlewares ='auth:api';
    }
    /**
     * Handles the HTTP request for the given chart.
     * It must always return an instance of Chartisan
     * and never a string or an array.
     */
    public function handler(Request $request): Chartisan
    {
        $startdatestart = date("Y-m-d", strtotime($request['startdatestart']));
        $startdateend   = date("Y-m-d", strtotime($request['startdateend']));
        $enddatestart   = date("Y-m-d", strtotime($request['enddatestart']));
        $enddateend     = date("Y-m-d", strtotime($request['enddateend']));
        $lang           = $request['lang'];
        $ids            = $request['ids'];

        if($ids == "")
        {
            $feelingstart = Emoji::withCount(['feelings' => function($q) use($startdatestart, $startdateend){
                return $q->where('feeling_emoji.user_id', Auth::id())
                        ->whereBetween('feeling_emoji.created_at', [$startdatestart.' 00:00:00',$startdateend.' 23:59:59']);
            }])->get();
    
            $feelingend = Emoji::withCount(['feelings' => function($q) use($enddatestart, $enddateend){
                return $q->where('feeling_emoji.user_id', Auth::id())
                        ->whereBetween('feeling_emoji.created_at', [$enddatestart.' 00:00:00',$enddateend.' 23:59:59']);
            }])->get();
        }else
        {
            $ids            = explode(',', $request['ids']);
            $feelingstart   = Emoji::whereIn('id', $ids)
                                 ->withCount(['feelings' => function($q) use($startdatestart, $startdateend){
                                        return $q->where('feeling_emoji.user_id', Auth::id())
                                                 ->whereBetween('feeling_emoji.created_at', [$startdatestart.' 00:00:00',$startdateend.' 23:59:59']);
                                    }])->get();
    
            $feelingend = Emoji::whereIn('id', $ids)
                               ->withCount(['feelings' => function($q) use($enddatestart, $enddateend){
                                    return $q->where('feeling_emoji.user_id', Auth::id())
                                            ->whereBetween('feeling_emoji.created_at', [$enddatestart.' 00:00:00',$enddateend.' 23:59:59']);
                                }])->get();
        }

        
        $totalstart = 0;
        $totalend   = 0;

        foreach($feelingstart as $feel)
        {
            $totalstart += $feel->feelings_count;
        }
        foreach($feelingend as $feel)
        {
            $totalend += $feel->feelings_count;
        }

        $types = $feelingstart->map(function($feel) use ($lang){
            $type = 'type_' . $lang;
            return $feel->$type;
        })->toArray();

        $countsStart = $feelingstart->map(function($feel){
            return $feel->feelings_count;
        })->toArray();

        $countsEnd = $feelingend->map(function($feel){
            return $feel->feelings_count;
        })->toArray();


        return Chartisan::build()
            ->labels($types)
            ->dataset('Feeling', $countsStart)
            ->dataset('Feeling2', $countsEnd);
    }
}