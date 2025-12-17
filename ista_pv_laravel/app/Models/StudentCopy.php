<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCopy extends Model
{
    use HasFactory;

    protected $fillable = ['pv_id','student_identifier','file_path','copy_type','uploaded_by'];

    public function pv()
    {
        return $this->belongsTo(PV::class);
    }

    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }
}
