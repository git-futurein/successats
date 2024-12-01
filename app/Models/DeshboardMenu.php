<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DeshboardMenu extends Model
{
    use HasFactory;

    public function getActivitylogOptions():LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['menu_group',
        'menu_icon',
        'menu_name',
        'menu_path',
        'menu_perent',
        'menu_status',
        'menu_short',
        'exception'])
        ->setDescriptionForEvent(fn(string $eventName) => Auth::user()->name." has been {$eventName}" )
        ->useLogName('MenuLogs')
        ->logOnlyDirty()
        ->dontSubmitEmptyLogs();
    }


    protected $fillable = [
            'menu_group',
            'menu_icon',
            'menu_name',
            'menu_path',
            'menu_perent',
            'menu_status',
            'menu_short',
            'exception'
        ];

        public function parent()
        {
            return $this->belongsTo(DeshboardMenu::class, 'menu_perent');
        }

        public function childs() {
            return $this->hasMany(DeshboardMenu::class,'menu_perent','id') ;
        }
    protected static $logAttributes = [
            'menu_group',
            'menu_icon',
            'menu_name',
            'menu_path',
            'menu_perent',
            'menu_status',
            'menu_short',
            'exception'
        ];



    public static function boot()
    {
        parent::boot();
        static::created(function ($DeshboardMenu) {
            $DeshboardMenu->slug = $DeshboardMenu->generateSlug($DeshboardMenu->menu_name);
            $DeshboardMenu->created_by = Auth::user()->id;
            $DeshboardMenu->userRole_id = Auth::user()->role_id;
            $DeshboardMenu->save();
        });

        // Update field update_by with current user id each time article is updated.
        static::updating(function ($DeshboardMenu) {
            $DeshboardMenu->modify_by = Auth::user()->id;
            // $DeshboardMenu->save();
        });
    }

    private function generateSlug($menu_name)
    {
        if (static::whereSlug($slug = Str::slug($menu_name))->exists()) {
            $max = static::whereName($menu_name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
