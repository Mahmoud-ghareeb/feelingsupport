<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait Shareable{

    public function saveSharedImage($imagedata)
    {
        $image = base64_decode($imagedata);
        $image_name = md5(uniqid(rand(), true));
        $filename = $image_name . '.' . 'png';
        file_put_contents('assets/images/feels/' . $filename, $image);
        $image_s = 'assets/images/feels/' . $filename;
        return $image_s;
    }

}