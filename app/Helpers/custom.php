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
        // $filePath = $file->storeAs($path, $filename, $disk);

        $file->move(public_path('storage/'.$path),$filename);
        $fullPath = $path.$filename;

        return $fullPath;
    }

    // public static function uploadFile($file, $folder_name = null, $disk = 'public', $filePath = 'uploads')
    // {
    //     if ($folder_name) {
    //         $path = $filePath . '/' . $folder_name;
    //     }

    //     // Generate a unique filename with the original file extension
    //     $filename = uniqid() .'test'. '.' . $file->getClientOriginalExtension();

    //     // Store the file on the given disk using the path and filename
    //     // $filePath = $file->storeAs($path, $filename, $disk);

    //     $filePath = $file->move(storage_path($filePath . '/candidate'), $filename);
    //     // dd($filePath);
    //     // Return the file path
    //     // return $filePath;
    // }



    public static function modify_name($modify_id) {
        return User::find($modify_id)->name;
    }
    public static function usr() {
        return Auth::guard('web')->user();
    }
}
