<?php
namespace App\Helpers;

class Helpers{
    public static function photoUpload($photo, $folder){
        // get filename with extension
        $fileNameWithExt = $photo->getClientOriginalName();
    
        // get just filename
        $fileName = pathinfo( $fileNameWithExt, PATHINFO_FILENAME );
    
        // get just extension
        $extension = $photo->getClientOriginalExtension();
    
        // store filename
        $fileNameToStore = $fileName.'_'.time().'.'.$extension;
    
        // upload image
        $path = $photo->storeAs('public/'.$folder, $fileNameToStore );
    
        return $fileNameToStore;
    }

}

