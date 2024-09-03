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

    protected $link;

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
        $extractedData = LinkDataExtractor::extract($link->url);
        $newContent = $extractedData['content'];

        $user = Auth::user();

        ChangeHistory::create([
            'link_id' => $link->id,
            'old_content' => json_encode($link->content),
            'new_content' => json_encode($newContent),
            'user_id' => $user ? $user->id : null,
            'name' => $user ? $user->name : 'System',
        ]);

        if ($this->compareContent($link->content, $newContent)) {
            $link->update([
                'content' => $newContent,
            ]);
        }
    }

    function compareContent($content1, $content2) {
        return $this->normalizeContent($content1) === $this->normalizeContent($content2);
    }

    function normalizeContent($content) {

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
