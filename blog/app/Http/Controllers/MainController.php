<?php

namespace App\Http\Controllers;

use App\Department;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    public function createEmployee(Request $request)
    {
        $error = null;
        $status = 'bad';

        try {
            $firstName = $request->get('first_name');
            $secondName = $request->get('second_name');
            $thirdName = $request->get('third_name');
            $gender = $request->get('gender');
            $salary = $request->get('salary');
            $keys = $request->get('keys');
            $employee = new Employee();
            $employee->first_name = $firstName;
            $employee->second_name = $secondName;
            $employee->third_name = $thirdName;
            $employee->gender = $gender;
            $employee->salary = $salary;
            $employee->save();
            $employee->departments()->attach($keys);
            $status = 'good';
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return json_encode([
           'status' => $status,
           'error' => $error
        ]);
    }

    public function updateEmployee($id, Request $request)
    {
        $error = null;
        $status = 'bad';

        try {
            $firstName = $request->get('first_name');
            $secondName = $request->get('second_name');
            $thirdName = $request->get('third_name');
            $gender = $request->get('gender');
            $salary = $request->get('salary');
            $keys = $request->get('keys');
            $employee = Employee::find($id);
            $employee->first_name = $firstName;
            $employee->second_name = $secondName;
            $employee->third_name = $thirdName;
            $employee->gender = $gender;
            $employee->salary = $salary;
            $employee->save();
            $employee->departments()->detach();
            $employee->departments()->attach($keys);
            $status = 'good';
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return json_encode([
            'status' => $status,
            'error' => $error
        ]);
    }


    public function createDepartment(Request $request)
    {
        $error = null;
        $status = 'bad';

        try {
            $name = $request->get('name');
            $department = new Department();
            $department->name = $name;
            $status = 'good';
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return json_encode([
            'status' => $status,
            'error' => $error
        ]);
    }

    public function updateDepartment($id, Request $request)
    {
        $error = null;
        $status = 'bad';

        try {
            $name = $request->get('name');
            $department = Department::find($id);
            $department->name = $name;
            $status = 'good';
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }

        return json_encode([
            'status' => $status,
            'error' => $error
        ]);
    }

    public function getAll()
    {
        $var = DB::table('departments as d')
            ->join('departments_employees as s', 'd.id', '=', 's.department_id')
            ->join('employees as f', 'd.id', '=', 'f.id')
            ->select('*')->get();

        $mix = [];

        foreach ($var->toArray() as $item) {
            $mix[] = json_decode(json_encode($item), true);
        }

        $b = 0;
        foreach ($mix as $item) {
            if ($item['salary'] > $b) {
                $b = $item['salary'];
            }
        }

        $der = [];
        $df = 0;
        foreach ($mix as $item) {
            $der[$df]['dep_id'] = $item['department_id'];
            $der[$df]['name'] = $item['name'];
            $der[$df]['employee_mark'] = $item['employee_mark'];
            $der[$df]['count'] = $this->primary($mix, $item['name']);
            $der[$df]['salary'] = $item['salary'];
            $df++;
        }
        $cer = [];
        $wer = [];
        foreach ($der as $item) {
            if(in_array($item['dep_id'], $cer)){
                continue;
            } else {
                $wer[] = $item;
                array_push($cer, $item['dep_id']);
            }
        }
        $wer['max'] = $b;
        return json_encode($wer);
    }

    public function primary ($mix, $name)
    {
        $items = [];
        foreach($mix as $item) {
            $items[]['connect'] = [$item['name'] => $item['employee_mark']];
        }

        $counter = 0;
        foreach ($items as $item) {
            if (isset($item['connect'][$name])) {
                //var_dump($item['connect'][$name]);
                ++$counter;
            }
        }
        return $counter;
    }

    public function getAllEmployees()
    {
        $var = Employee::all();
        return json_encode($var->toArray());
    }

    public function deleteEmployee($id)
    {
        $ex = null;
        $status = 'bad';
        try {
            $employee = Employee::find($id);
            $employee->delete();
            $status = 'good';
        } catch(\Exception $ex) {
            $ex = $ex->getMessage();
        }
        return json_encode([
           'status' => $status,
           'error' => $ex
        ]);
    }

    public function deleteDepartment($id)
    {
        $ex = null;
        $status = 'bad';
        try {
            $department = Department::find($id);
            $department->delete();
        } catch (\Exception $ex) {
            $ex = $ex->getMessage();
        }
        return json_encode([
            'status' => $status,
            'error' => $ex
        ]);
    }
}
