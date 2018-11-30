<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class ImageController extends Controller
{
    public function upload(Request $request)
    {
    	$user=new user();
       if ($request->hasFile('photo'))
        {
       	 $imagname=$request->photo->getClientOriginalName();
       	 $request->photo->storeAs('public',$imagname);
       }
       $user->photo=$imagname;
       $user->save();
       return back();
    }
}
