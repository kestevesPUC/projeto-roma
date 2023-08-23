<?php

namespace App\Models\Empresa;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'empresa';



    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';



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
