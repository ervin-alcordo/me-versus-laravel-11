<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PartType;
use App\Models\Manufacturer;

class SystemWideParts extends Model
{
    use HasFactory;

    protected $table = 'system_wide_parts';

    protected $fillable = [
        'active',
        'part_type_id',
        'manufacturer_id',
        'model_number',
        'list_price',
    ];

    public function partType()
    {
        return $this->belongsTo(PartType::class, 'part_type_id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id'); 
    }
    
}
