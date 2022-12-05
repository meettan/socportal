<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    //use Notifiable;
    //public $timestamps = false;
    protected $table = 'td_payment';
    protected $fillable = [
        'trans_date', 'payment_type','soc_id','brn_id','amount','cheque_no','cheque_dt','bank_name','ifs_code','cheque_img'
    ];
}
