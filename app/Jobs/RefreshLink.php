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
use Illuminate\Support\Facades\Auth;

class RefreshLink implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ?Link $link;

    /**
     * @param  Link|null  $link
    **/
    public function __construct(Link $link = null)
    {
        $this->link = $link;
    }

    public function handle(): void
    {
        if ($this->link) {
            $this->refreshSingleLink($this->link);
        } else {
            $links = Link::where('status', 'active')->get();
            foreach ($links as $link) {
                $this->refreshSingleLink($link);
            }
        }
    }

    /**
     * @param  Link  $link
     */
    protected function refreshSingleLink(Link $link): void
    {
        $extractedData = LinkDataExtractor::extract($link->url, $link->headers, $link->query_paramters);
        $newContent = $extractedData['content'];

        $user = Auth::user();
        $content_changed  = $this->isContentChanged($link->content, $newContent);

        if ($content_changed) {
            $link->update([
                'content' => $newContent,
            ]);
        }

        ChangeHistory::create([
            'link_id' => $link->id,
            'old_content' => json_encode($link->content),
            'new_content' => json_encode($newContent),
            'user_id' => $user?->id,
            'is_changed' => $content_changed,
            'name' => $user ? $user->name : 'System',
        ]);
    }

    function isContentChanged($content1, $content2): bool
    {
        return $this->normalizeContent($content1) !== $this->normalizeContent($content2);
    }

    function normalizeContent($content): string
    {
        $decodedContent = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return trim(preg_replace('/\s+/', ' ', $content));
        }

        if (is_array($decodedContent)) {
            return json_encode($decodedContent, JSON_PRETTY_PRINT);
        }

        return trim(preg_replace('/\s+/', ' ', $decodedContent));
    }


}
