<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'old_content', 'new_content', 'change_location', 'user_id', 'name' ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($link) {
            activity()
                ->performedOn($link)
                ->causedBy(auth()->user())
                ->log('History created');
        });
    }

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
