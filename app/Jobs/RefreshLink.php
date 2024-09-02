<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Link;
use App\Models\ChangeHistory;
use App\Services\LinkDataExtractor;

class RefreshLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $link;

    /* @param  Link  $link */
    public function __construct(Link $link)
    {
        $this->link = $link;
    }

    public function handle(): void
    {
        $extractedData = LinkDataExtractor::extract($this->link->url);
        $newContent = $extractedData['content'];

        ChangeHistory::create([
            'link_id' => $this->link->id,
            'old_content' => $this->link->content,
            'new_content' => $newContent,
        ]);

        if ($this->link->content !== $newContent) {
            $this->link->update([
                'content' => $newContent,
            ]);
        }
    }
}
