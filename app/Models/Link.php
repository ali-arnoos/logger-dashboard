<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'headers', 'query_parameters', 'method', 'status'];

    protected $casts = [
        'headers' => 'array',
        'query_parameters' => 'array',
    ];

    public function contents()
    {
        return $this->hasMany(LinkContent::class);
    }

    public function changes()
    {
        return $this->hasMany(ChangeHistory::class);
    }
}
