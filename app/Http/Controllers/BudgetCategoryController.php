<?php

namespace App\Http\Controllers;

use App\BudgetCategory;
use App\BudgetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('budgetcategories.index', [
            'categories' => BudgetCategory::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = request()->validate([
            'name' => ['required'],
            'type' => ['required'],
            'per_member' => [],
            'maximum' => [],
            'hardship' => [],
            'private' => [],
        ]);
        if ($request['type'] != 'c' && $request['type'] != 'd') {
            return abort(403, "Wrong type");
        }
        $request['maximum'] = $request['maximum'] ?: 0;

        try {
            $cat = new BudgetCategory($request);
            $cat->save();

            return $cat;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BudgetCategory  $budgetCategory
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return BudgetCategory::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BudgetCategory  $budgetCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BudgetCategory $budgetCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BudgetCategory  $budgetCategory
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $request = request()->validate([
            'id' => ['required'],
            'name' => ['required'],
            'type' => ['required'],
            'per_member' => [],
            'maximum' => [],
            'hardship' => [],
            'private' => [],
        ]);
        if ($request['type'] != 'c' && $request['type'] != 'd') {
            return abort(403, "Wrong type");
        }

        $cat = BudgetCategory::find($request['id']);
        if (!$cat) {
            return abort(404);
        }

        $cat->name = $request['name'];
        $cat->type = $request['type'] ?: $cat->type;
        $cat->per_member = isset($request['per_member']) && $request['per_member'] ? $request['per_member'] : $cat->per_member;
        $cat->maximum = isset($request['maximum']) && $request['maximum'] ? $request['maximum'] : $cat->maximum;
        $cat->hardship = isset($request['hardship']) && $request['hardship'] ? $request['hardship'] : $cat->hardship;
        $cat->private = isset($request['private']) && $request['private'] ? $request['private'] : $cat->private;
        $cat->save();

        return $cat;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BudgetCategory  $budgetCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $b = BudgetCategory::find($id);

        $item = BudgetItem::where("budget_category_id", $id)->first();

        if ($b && !$item) {
            $b->delete();
        } else {
            return abort(403);
        }

        return [
            'status' => 1,
        ];
    }
}
