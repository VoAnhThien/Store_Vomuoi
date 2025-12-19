<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'original_price',
        'stock',
        'image_url',
        'color',
        'dimensions',
        'category_id',
        'is_featured',
        'is_active',
        'sold_count',
        'rating',
        'review_count'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Accessor để có thể dùng $product->name
    public function getNameAttribute()
    {
        return $this->product_name;
    }

    // Accessor để có thể dùng $product->image
    public function getImageAttribute()
    {
        return $this->image_url;
    }

    // Tính % giảm giá
    public function getDiscountAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    // Format giá VND
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.') . 'đ';
    }

    public function getFormattedOriginalPriceAttribute()
    {
        return number_format($this->original_price, 0, ',', '.') . 'đ';
    }

    // Relationship
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'product_id');
    }

    // Scope để lấy sản phẩm active
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    // Scope để lấy sản phẩm nổi bật
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }
}
