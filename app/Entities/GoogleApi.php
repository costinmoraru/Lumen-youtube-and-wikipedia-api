<?php


namespace App\Entities;


use Illuminate\Database\Eloquent\Model;

class GoogleApi extends Model
{

    /**
     * @var string
     */
    protected $table = 'google_api';

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var array
     */
    protected $casts = [
        'response' => 'array'
    ];
}
