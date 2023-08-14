<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Position;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $position = Position::all();
        return view('admin.users.create', compact('position'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'admin' => 'required',
            'email' => 'required|email|unique:users',
            'position_id' => 'required',
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->admin = $request->admin;
        $user->position_id = $request->position_id;
        $user->password = bcrypt($request->password);


        if($user->save()){
            return redirect()->route('admin.users.index')->with('success', 'Record created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        $position = Position::all();
        $position_selected = User::find($id)->position()->get();

        return view('admin.users.edit', compact('user', 'position', 'position_selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $id = Crypt::decrypt($id);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->admin = $request->admin;
        $user->position_id = $request->position_id;

        if($user->save()){
            return redirect()->route('admin.users.index')->with('success', 'Record updated successfully!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $user = User::findOrFail($id);
        if(Auth::user()->id == $user->id){
            return redirect()->back()->with('error', 'Error the user is currently being used by you!');
        }else{
            $user->delete();

            return redirect()->route('admin.users.index')->with('success', 'Record deleted successfully!');
        }
    }
}
