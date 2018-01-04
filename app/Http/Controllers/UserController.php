<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Animal;

class UserController extends Controller
{
    /**
     * Max limit per row to display
     */
    const ROW_LIMIT = 20;

    public function index(Request $request)
    {

        if (! $request->wantsJson())
        {
            return view('events.index');
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

        $query = Animal::query();

        if ($searchIndex && $searchValue)
        {
            $query->where($searchIndex, 'like',sprintf('%s%%', $searchValue));
        }

        if(($rows = $query->count()) > 0 ){
            $status = 200;
            $pages = (int)ceil($rows / $limit);
            $offset = --$page * $limit;

            $list = $query->orderBy($sortIndex, $sortOrder)->limit($limit)->offset($offset)->get();
        }

        return response()->json(compact('rows', 'pages', 'list'), $status);

    }
}
