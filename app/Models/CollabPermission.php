<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollabPermission extends Model
{
    use HasFactory;
    protected $table = 'collab_permission';
    protected $fillable = [
        'user_id',
        'product_id',
    ];
}
?>