<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeHistory extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'old_content', 'new_content', 'change_location'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
