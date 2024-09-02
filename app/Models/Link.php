<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\RefreshLink;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Link extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $fillable = ['url', 'headers', 'query_parameters', 'method', 'status', 'content'];

    protected $casts = [
        'headers' => 'array',
        'query_parameters' => 'array',
        'content' => 'array',
    ];

    public function changes()
    {
        return $this->hasMany(ChangeHistory::class);
    }

    public function refreshLink(): void
    {
        RefreshLink::dispatch($this);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }
}
