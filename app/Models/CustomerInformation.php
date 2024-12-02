<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BottlingDetails;
class CustomerInformation extends Model
{
    use HasFactory;
    protected $guarded = [''];

    public function bottlingDetails()
    {
        return $this->hasMany(BottlingDetails::class);
    }
    
}
