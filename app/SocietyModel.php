<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SocietyModel extends Model
{
    protected $table = 'v_ferti_soc';
    protected $fillable = [
        'soc_id', 'soc_name', 'soc_add','district','pin', 'ph_no', 'email','pan','gstin','mfms',
    ];

}
