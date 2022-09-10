<?php

namespace App\Traits;

trait Imageable
{
 
    public function saveImage($photo, $folder)
    {
        $ext  = $photo -> getClientOriginalExtension();
        $name = time() . "." . $ext;
        $photo->move($folder, $name);
        return $folder . "/" . $name; 
    }

}