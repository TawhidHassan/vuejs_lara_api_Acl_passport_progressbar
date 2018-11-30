<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        /*$this->authorize('isAdmin');*//*for filter the user */
        if (\Gate::allows('isAdmin')|| \Gate::allows('isAuthor')) {
            return User::latest()->paginate(5);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:191',
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|string|min:6'
        ]);
        return User::create([
          'name'=> $request['name'],
          'email'=> $request['email'],
          'type'=> $request['type'],
          'bio'=> $request['bio'],
          'photo'=> $request['photo'],
          'password'=>Hash::make( $request['password']),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
    }

    public function updateProfile(Request $request)
    {
        

        $user= auth('api')->user();

        $this->validate($request,[
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|min:6'
        ]);
         
       

         if(!empty($request->password)){
            $request->merge(['password'=> Hash::make($request['password'])]);
         }
        $user->update($request->all());
        return ['massage','sucsess'];

    }
     public function show($id)
    {
        //
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
         $user=User::findOrFail($id);


        $this->validate($request,[
            'name' => 'max:191',
            'email' => 'email|max:191|unique:users,email,'.$user->id, /*for this extra line it is use for not need to change user emaill*/
            'password' => 'sometimes|min:6'
        ]);
        
          $user->update($request->all());



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user=User::findOrFail($id);
        $user->delete();
    }
     public function search(){
        if ($search = \Request::get('q')) {
            $users = User::where(function($query) use ($search){
                $query->where('name','LIKE',"%$search%")
                        ->orWhere('email','LIKE',"%$search%");
            })->paginate(20);
        }else{
            $users = User::latest()->paginate(5);
        }
        return $users;
    }

}
