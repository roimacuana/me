<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'employees';

    /**
     * Timestamp
     * @var bool
     */
    public $timestamps = false;

    /**
     * Fillables
     * @var array
     */
    protected $fillable = ['title'

    ];

    /**
     * Validation Rules
     * @var array
     */
    protected $rules = [

    ];


}