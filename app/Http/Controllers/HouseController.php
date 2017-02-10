<?php

namespace App\Http\Controllers;
use App\House;
use Auth;
use Webpatser\Uuid\Uuid;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index()
    {
        return view('house/index');
    }
    public function create(Request $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $house = $user->houses()->create([
                'id' => Uuid::generate(),
                'name' => $data['name'],
                'rent' => $data['rent'],
                'ebase' => 1.3,
                'wbase' => 7,
                'fees' => $data['fees'],
                'deposit' => $data['deposit'],
            ]);
    	return ['state' => 'created','house' => $house];
    }
    public function show()
    {
        $user = Auth::user();
        return House::where('user_id',$user->id)->get();
    }
    public function update()
    {
    	return ['state' => 'update'];
    }
    public function delete()
    {
    	return ['state' => 'delete'];
    }
}
