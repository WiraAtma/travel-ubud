<?php
namespace App\Models\Company;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CompanyRequest extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'field',
        'reason',
        'proof_file',
        'status',
        'rejection_reason',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    public function statusLabel(): string
    {
        return match($this->status) {
            'pending'  => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => '-',
        };
    }

    public function fieldLabel(): string
    {
        return match($this->field) {
            'restaurant'  => 'Restoran',
            'destination' => 'Destinasi',
            'hotel'       => 'Hotel',
            default       => '-',
        };
    }
}