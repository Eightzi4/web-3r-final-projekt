<?php

namespace Database\Factories;

use App\Models\M_DeveloperImages;
use App\Models\M_Developers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\M_DeveloperImages>
 */
class DeveloperImagesFactory extends Factory // Ensure class name matches file name
{
    protected $model = M_DeveloperImages::class;

    public function definition(): array
    {
        // Generate a placeholder image URL or path
        // For actual images, you'd need to have them or use a service
        $width = 640;
        $height = 480;
        return [
            'image' => "https://via.placeholder.com/{$width}x{$height}.png/0077 разделе?text=DevImage+" . fake()->word,
            // 'developer_id' is usually set when calling the factory, e.g., in DeveloperFactory or Seeder
            'developer_id' => M_Developers::factory(), // Or provide when calling
        ];
    }
}
