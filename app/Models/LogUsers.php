<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUsers extends Model
{
    protected $table ='log_users';
    use HasFactory;
    protected $guarded = ['id'];
}
