<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id'; // THÊM DÒNG NÀY

    protected $fillable = [
        'user_id', // SỬA thành user_id (database có user_id, không có customer_name, etc.)
        'total_amount',
        'order_status', // SỬA thành order_status
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    // THÊM accessor để tương thích với code cũ
    public function getStatusAttribute()
    {
        return $this->order_status;
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusLabelAttribute()
    {
        $statusLabels = [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'shipped' => 'Đang giao hàng',
            'delivered' => 'Đã giao hàng',
            'completed' => 'Hoàn thành', // THÊM completed
            'cancelled' => 'Đã hủy'
        ];

        return $statusLabels[$this->order_status] ?? $this->order_status;
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.') . ' đ';
    }
}
