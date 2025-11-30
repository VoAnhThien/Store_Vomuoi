<?php
// app/Models/Product.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id'; // THÊM DÒNG NÀY
    
    protected $fillable = [
        'product_name', 
        'description',
        'price',
        'stock', 
        'image_url',
        'color',
        'dimensions',
        'category_id',
        'is_featured', // CẦN THÊM CỘT NÀY VÀO DATABASE
        'is_active' // CẦN THÊM CỘT NÀY VÀO DATABASE
    ];

    public function getNameAttribute()
    {
        return $this->product_name;
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function getImageAttribute()
    {
        return $this->image_url;
    }


    public function getDiscountAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }
}
