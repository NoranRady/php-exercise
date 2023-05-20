<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'company_id',
        'start_date',
        'end_date',
        'email',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
