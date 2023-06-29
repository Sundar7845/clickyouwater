<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManufacturerDocuments extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'manufacture_id',
        'documenttype_id',
        'documentmodule_id',
        'document_path',
        'document_number',
        'is_verified'
    ];

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'documenttype_id', 'id');
    }

    public function documentconfig()
    {
        return $this->belongsTo(DocumentConfig::class, 'documenttype_id', 'documenttype_id');
    }
}
