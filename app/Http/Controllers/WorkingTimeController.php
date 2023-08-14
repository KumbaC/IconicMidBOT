<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\working_time;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class WorkingTimeController extends Controller
{

    public function index()
    {
        $working = working_time::all();
        //dd($working);
        return view("admin.working.index",compact('working'));
    }

    public function create()
    {
        $user = User::all();
        return view("admin.working.create", compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'=> 'required',
            'entry_date' => 'required',
            'lunch_time' => 'required',
            'break' => 'required',
            'break_two' => 'required',
            'out' => 'required',
        ]);


        working_time::create($request->all());
        return redirect()->route('admin.working.index')->with('success','The working time was created successfully!');
    }

    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $working = working_time::findOrFail($id);
        $user = User::all();
        $user_selected = working_time::find($id)->user()->get();
        return view("admin.working.edit", compact('working', 'user_selected', 'user'));
    }

    public function update(Request $request, string $id)
    {
       /*  $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:categories',
        ]); */
        $id = Crypt::decrypt($id);
        working_time::find($id)->update($request->all());

        return redirect()->route('admin.working.index')->with('info','The working time was updated successfully!');
    }
    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $working = working_time::findOrFail($id);

        return view('admin.working.show', compact('working'));
    }

    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        $working = working_time::find($id);
        if($working->delete()){
            return Redirect()->route('admin.working.index')->with('error','the working time was deleted successfully!');
        }

    }
}
