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
        return $this->normalizedStatus() === 'pending';
    }

    public function isApproved(): bool
    {
        return $this->normalizedStatus() === 'approved';
    }

    public function isRejected(): bool
    {
        return $this->normalizedStatus() === 'rejected';
    }

    public function statusLabel(): string
    {
        return match($this->normalizedStatus()) {
            'pending'  => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            default    => '-',
        };
    }

    private function normalizedStatus(): string
    {
        return strtolower(trim((string) $this->status));
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
