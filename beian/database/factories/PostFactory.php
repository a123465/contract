<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\PostMedia;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $spots = [
            '故宫', '长城', '西湖', '黄山', '张家界', '桂林漓江', '丽江古城', '九寨沟', '秦始皇兵马俑', '鼓浪屿',
            '成都熊猫基地', '颐和园', '苏州园林', '壶口瀑布', '青海湖', '庐山', '泰山', '西安城墙', '南浔古镇', '澳门大三巴'
        ];

        $activities = [
            '打卡', '徒步', '摄影', '美食探店', '温泉放松', '文化探访', '自驾', '亲子游', '背包旅行', '慢生活体验'
        ];

        $adjectives = [
            '难忘的', '美丽的', '安静的', '惊艳的', '热闹的', '典雅的', '神秘的', '古朴的', '壮观的', '惬意的'
        ];

        $spot = $this->faker->randomElement($spots);
        $activity = $this->faker->randomElement($activities);
        $adj = $this->faker->randomElement($adjectives);

        $title = "{$spot}：{$adj}{$activity}";

        // 生成若干段中文内容的描述
        $paragraphs = [];
        $paragraphTemplates = [
            "我在{$spot}度过了一段{$adj}的时光，沿途看到了很多值得回味的瞬间。",
            "建议大家去的时候带上相机，特别是拍摄{$spot}的日出和日落。",
            "当地的美食也很不错，尤其是周边的小吃，吃完还想再来。",
            "交通比较方便，适合和朋友或者家人一起来一次短途旅行。",
            "如果你喜欢自然风光，{$spot}的景色一定不会让你失望。",
        ];

        $paraCount = $this->faker->numberBetween(2, 4);
        for ($i = 0; $i < $paraCount; $i++) {
            $paragraphs[] = $this->faker->randomElement($paragraphTemplates);
        }

        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $title,
            'content' => implode("\n\n", $paragraphs),
            'category' => $this->faker->randomElement(['城市旅行', '户外冒险', '海滩度假', '文化体验', '美食探索']),
        ];
    }

    /**
     * Configure the factory to add media after creating a post.
     */
    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Post $post) {
            // 示例占位图片 URL（picsum）或国内图片 CDN 可替换为更合适的源
            $placeholders = [
                'https://picsum.photos/1200/800?random=1',
                'https://picsum.photos/1200/800?random=2',
                'https://picsum.photos/1200/800?random=3',
                'https://picsum.photos/1200/800?random=4',
                'https://picsum.photos/1200/800?random=5',
            ];

            $count = rand(1, 3);
            $sort = 0;

            for ($i = 0; $i < $count; $i++) {
                $url = $this->faker->randomElement($placeholders);

                try {
                    $res = Http::withOptions(['verify' => false])->get($url);
                    if ($res->ok()) {
                        $ext = 'jpg';
                        $filename = 'posts/' . uniqid('img_') . '.' . $ext;
                        Storage::disk('public')->put($filename, $res->body());

                        PostMedia::create([
                            'post_id' => $post->id,
                            'file_path' => $filename,
                            'file_name' => basename($filename),
                            'mime_type' => 'image/jpeg',
                            'file_type' => 'image',
                            'sort_order' => $sort++,
                        ]);
                    }
                } catch (\Exception $e) {
                    // 忽略下载错误，继续下一张
                }
            }
        });
    }
}
