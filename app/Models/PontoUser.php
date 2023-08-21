<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoUser extends Model
{
    
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'controle_ponto';

 

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = '';

 

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

 

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
