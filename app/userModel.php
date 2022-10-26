<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userModel extends Model
{
    protected $table = 'td_users';
    protected $fillable = [
        'name','pan', 'email', 'password','soc_name','soc_address','gstin','mfms','created_by','updated_by'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];
}
