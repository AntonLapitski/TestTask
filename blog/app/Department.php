<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'departments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    public function employees()
    {
        return $this->belongsToMany(
            Employee::class,
            'departments_employees',
            'employee_id',
            'department_id'
        );
    }
}
