<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attendance extends Model
{
    protected $fillable = ['makul_id', 'pertemuan_ke', 'tanggal', 'catatan', 'created_by'];

    protected $casts = ['tanggal' => 'date'];

    public function makul(): BelongsTo
    {
        return $this->belongsTo(Makul::class, 'makul_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_id');
    }
}
