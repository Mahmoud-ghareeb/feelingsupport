<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddEmojiRequest;
use App\Models\Emoji;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class EmojiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function manageEmojis()
    {
        $this->authorize('adminPermission', Auth::user());
        $emojis = Emoji::orderBy('raw_order')->get();
        return view('admin.pages.manage_emojis', compact('emojis'));                
    }

    public function addEmoji()
    {
        $this->authorize('adminPermission', Auth::user());
        return view('admin.pages.add_emoji');
    }

    public function createEmoji(AddEmojiRequest $request)
    {
        $this->authorize('adminPermission', Auth::user());
        Emoji::create([
            'type_en' => $request->type_en,
            'type_ar' => $request->type_ar,
            'type_es' => $request->type_es,
            'type_fr' => $request->type_fr,
            'type_it' => $request->type_it,
            'type_tr' => $request->type_tr,
            'type_hi' => $request->type_hi,
            'type_zh' => $request->type_zh,
            'type_de' => $request->type_de,
            'type_ur' => $request->type_ur,
            'type_fa' => $request->type_fa,
            'type_bn' => $request->type_bn,
            'type_id' => $request->type_id,
            'type_ru' => $request->type_ru,
            'type_pt' => $request->type_pt,
            'type_ko' => $request->type_ko,
            'type_ja' => $request->type_ja,
            'type_ms' => $request->type_ms,
            'category' => $request->category,
            'css_class' => $request->css_class,
            'color' => $request->color
        ]);
        return redirect()->to(route('admin.manage.emojis'))->with('info_message', 'Emoji created successfully');
    }

    public function editEmoji($emoji_id)
    {
        $this->authorize('adminPermission', Auth::user());
        $user = Emoji::findOrFail($emoji_id);
        $emojis = Emoji::where('id', $emoji_id)->get();
        return view('admin.pages.edit_emoji', compact('emojis'));
    }

    public function modifyEmoji(AddEmojiRequest $request)
    {
        $this->authorize('adminPermission', Auth::user());
        $emoji = Emoji::findOrFail($request->id);

        $emoji->type_en  = $request->type_en;
        $emoji->type_ar  = $request->type_ar;
        $emoji->type_es  = $request->type_es;
        $emoji->type_fr  = $request->type_fr;
        $emoji->type_it  = $request->type_it;
        $emoji->type_tr  = $request->type_tr;
        $emoji->type_hi  = $request->type_hi;
        $emoji->type_zh  = $request->type_zh;
        $emoji->type_de  = $request->type_de;
        $emoji->type_ur  = $request->type_ur;
        $emoji->type_fa  = $request->type_fa;
        $emoji->type_bn  = $request->type_bn;
        $emoji->type_id  = $request->type_id;
        $emoji->type_ru  = $request->type_ru;
        $emoji->type_pt  = $request->type_pt;
        $emoji->type_ko  = $request->type_ko;
        $emoji->type_ja  = $request->type_ja;
        $emoji->type_ms  = $request->type_ms;
        $emoji->category  = $request->category;
        $emoji->css_class  = $request->css_class;
        $emoji->color  = $request->color;

        $emoji->save();
        return redirect()->to(route('admin.manage.emojis'))->with('info_message', 'Emoji edited successfully');
    }

    public function deleteEmoji($emoji_id)
    {
        $this->authorize('adminPermission', Auth::user());
        $emoji = Emoji::findOrFail($emoji_id);
        $emoji->delete();
        return redirect()->to(route('admin.manage.emojis'))->with('info_message', 'Emoji deleted successfully');
    }
    
    public function changeEmojisOrder()
    {
        $this->authorize('adminPermission', Auth::user());
        $emojis = Emoji::orderBy('raw_order')->get();
        return view('admin.pages.order_emojis', compact('emojis'));  
    }

    public function updateEmojisOrder(Request $request)
    {
        $this->authorize('adminPermission', Auth::user());
        $i = 0;
        $temp = array();
        foreach ($_GET['product_id'] as $row) {

            $s_emoji = Emoji::where('id', $row)->first();
            $s_emoji->raw_order = $i;
            $s_emoji->save();
            $i++;

        }

        return response()->json('success');
    }
}
