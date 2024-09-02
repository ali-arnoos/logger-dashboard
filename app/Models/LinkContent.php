<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkContent extends Model
{
    use HasFactory;

    protected $fillable = ['link_id', 'content', 'content_type'];

    public function link()
    {
        return $this->belongsTo(Link::class);
    }
}
