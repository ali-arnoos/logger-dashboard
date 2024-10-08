<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ChangeHistory extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['link_id', 'old_content', 'new_content', 'change_location', 'user_id', 'name', 'is_changed' ];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['url', 'old_content', 'new_content', 'change_location', 'user_id', 'name', 'is_changed'])
            ->logOnlyDirty() 
            ->useLogName('link') 
            ->setDescriptionForEvent(fn(string $eventName) => "History has been {$eventName}"); 
    }  
}
