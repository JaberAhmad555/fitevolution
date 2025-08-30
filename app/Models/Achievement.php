<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Achievement extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'milestone_key', 'name', 'description', 'badge_image','nft_transaction_hash'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}