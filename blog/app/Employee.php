<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'second_name', 'third_name', 'salary', 'gender'
    ];

    public function departments()
    {
        return $this->belongsToMany(
            Department::class,
            'departments_employees',
            'employee_mark',
            'department_id'
        );
    }
}
