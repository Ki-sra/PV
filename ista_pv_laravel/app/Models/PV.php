<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PV extends Model
{
    use HasFactory;

    protected $fillable = ['year','level','department','group','title','description','archived','created_by'];

    public function pvDocuments()
    {
        return $this->hasMany(PVDocument::class);
    }

    public function studentCopies()
    {
        return $this->hasMany(StudentCopy::class);
    }
}
