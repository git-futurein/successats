<?php

namespace App\Helpers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FileHelper
{
    public static function uploadFile($file, $folder_name = null, $disk = 'public', $path = 'uploads')
    {
        $path = $path.'/'.$folder_name;

        $filename = uniqid() . '_' . $file->getClientOriginalName();

        $file->move(public_path('storage/'.$path),$filename);
        $fullPath = $path.$filename;

        return $fullPath;
    }


    public static function modify_name($modify_id) {
        return User::find($modify_id)->name;
    }
    public static function usr() {
        return Auth::guard('web')->user();
    }
}
