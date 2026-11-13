<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
    // Dùng: $category->icon
    public function getIconAttribute(): string
    {
        $map = [
            'xếp hình'  => 'bi-puzzle',
            'xe'        => 'bi-truck',
            'búp bê'    => 'bi-emoji-smile',
            'thú bông'  => 'bi-heart',
            'giáo dục'  => 'bi-mortarboard',
            'vận động'  => 'bi-bicycle',
        ];

        $name = mb_strtolower($this->name);

        foreach ($map as $keyword => $icon) {
            if (str_contains($name, $keyword)) {
                return $icon;
            }
        }

        return 'bi-balloon'; // icon mặc định cho danh mục mới
    }
}
