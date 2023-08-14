<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class working_time extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

        //Relación uno a muchos
    public function user(){
        return $this->belongsTo(User::class);
    }

}
