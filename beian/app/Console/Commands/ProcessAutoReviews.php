<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ContentReview;

class ProcessAutoReviews extends Command
{
    protected $signature = 'reviews:process-auto {--limit=50}';
    protected $description = 'Run automated checks for pending content reviews';

    public function handle()
    {
        $limit = (int) $this->option('limit');
        $pending = ContentReview::where('status', 'pending')->limit($limit)->get();

        // 简单示例：基于关键字的自动标记，实际应调用更完善的文本审核服务
        $keywords = ['敏感词', '违法', '虚假'];

        foreach ($pending as $review) {
            $content = '';
            if ($review->reviewable) {
                // 常见模型字段：content, body, text; 视具体模型调整
                if (isset($review->reviewable->content)) $content = $review->reviewable->content;
                elseif (isset($review->reviewable->body)) $content = $review->reviewable->body;
            }

            $flags = [];
            foreach ($keywords as $k) {
                if ($content && mb_stripos($content, $k) !== false) {
                    $flags[] = $k;
                }
            }

            if (!empty($flags)) {
                $review->update([
                    'status' => 'auto-flagged',
                    'auto_checks' => ['matched_keywords' => $flags],
                ]);
                $this->info("Auto-flagged review {$review->id}: " . implode(',', $flags));
            } else {
                $this->info("No flags for review {$review->id}");
            }
        }

        return 0;
    }
}
