<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{

    /**
     * The constructor class.
     * @todo Set your middleware restriction here.
     */
    public function __construct()
    {

    }

    /**
     * Display a listing of the resource.
     * @route get /employees
     * @param $request Request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        if (! $request->wantsJson())
            {
                return view('employees.index');
            }

            $searchIndex = $request->input('searchIndex');
            $searchValue = $request->input('searchValue');
            $sortIndex = $request->input('sortIndex');
            $sortOrder = $request->input('sortOrder');

            $limit = (int)$request->input('limit'); $limit = $limit < 1 ? self::ROW_LIMIT : $limit;
            $page = (int)$request->input('page'); $page = $page < 1 ? 1 : $page;
            $status = 204;
            $pages = 0;
            $list = [];

            $query = Employee::query();

            if ($searchIndex && $searchValue)
            {
                $query->where($searchIndex, 'like',sprintf('%s%%', $searchValue));
            }

            if (($rows = $query->count()) > 0)
            {
                $status = 200;
                $pages = (int)ceil($rows / $limit);
                $offset = --$page * $limit;
                $list = $query->orderBy($sortIndex, $sortOrder)->limit($limit)->offset($offset)->get();
            }

            return response()->json(compact('rows', 'pages', 'list'), $status);

    }

    /**
     * Store a newly created resource in storage.
     * @route post /employees
     * @param $request Request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $employee = new Employee();

        $employee->fill($request->all());

        return $this->save($employee, 201);
    }


    /**
     * Update the specified resource in storage.
     * @route patch /employees
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        if (! $employee = Employee::find($id = $request->input('id')))
        {
            $message = sprintf("Not found id '%d'", $id);
            return response()->json(compact('message'), 404);
        }

        $employee->fill($request->all());

        return $this->save($employee, 200);
    }

    /**
     * Remove the specified resource from storage.
     * @route delete /employees
     * @param  Request  $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        if (! $employee = Employee::find($id = $request->input('id')))
        {
            $message = sprintf("Not found id '%d'", $id);
            return response()->json(compact('message'), 404);
        }

        if (! $employee->delete())
        {
            $message = sprintf("Unable to remove id '%d'", $id);
            return response()->json(compact('message'), 422);
        }

        $message = "Removed successfully";
        return response()->json(compact('message'));
    }


    /**
     * Save the specified resource from storage.
     *
     * @param Employee $employee
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Employee $employee, $status = 200)
    {
        $message = sprintf('%s successfully', $status == 200 ? "Updated" : "Created");

        $employee->save();

        return response()->json(compact('message'), $status);
    }

}

