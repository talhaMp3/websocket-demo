<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidding extends Model
{
    protected $table = 'bidding';
    use HasFactory;
    protected $fillable = ['price'];
}
