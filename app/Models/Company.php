<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use SoftDeletes;

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'email',
        'phone_number',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'company_id', 'id');
    }
}
