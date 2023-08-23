<?php

namespace App\Models\Perfil;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'perfil';



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
