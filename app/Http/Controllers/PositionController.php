<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PositionController extends Controller
{

    public function index()
    {

        $position = Position::all();
        return view("admin.positions.index",compact('position'));
    }

    public function create()
    {
        return view("admin.positions.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'description'=> 'required',
        ]);


        $position = Position::create($request->all());
        return redirect()->route('admin.positions.index')->with('success','Se creo con exito! ');
    }

    public function edit(string $id)
    {
        $id = Crypt::decrypt($id);
        $position = Position::findOrFail($id);

        return view("admin.positions.edit", compact('position'));
    }

    public function update(Request $request, string $id)
    {
       /*  $request->validate([
            'name'=> 'required',
            'slug'=> 'required|unique:categories',
        ]); */
        $id = Crypt::decrypt($id);
        Position::find($id)->update($request->all());

        return redirect()->route('admin.positions.index')->with('info','La categoria se actualizo con exito! ');
    }

    public function destroy(string $id)
    {
        $id = Crypt::decrypt($id);
        $positions = Position::find($id);
        if($positions->delete()){
            return Redirect()->route('admin.positions.index')->with('error','¡Se elimino con exito! ');
        }

    }
}
