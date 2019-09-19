<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use File;

class UserController extends Controller
{
   
    public function index()
    {
        return view("users.index");
    }

    public function listData()
    {
        $users = \App\User::orderBy("id","DESC")->get();
        $no = 0;
        $data = array();
        foreach($users as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->name;
            $row[] = $list->email;
            $row[] = "<div class='d-flex'>
                        <a href='javascript:void(0)' class='btn btn-primary btn-sm mr-2' onclick='editForm(".$list->id.")'><i class='fas fa-pencil-alt'></i></a>
                        <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='deleteData(".$list->id.")'><i class='fas fa-trash'></i></a>
                     </div>";
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);
    }

    public function store(Request $request)
    {
       $users = new \App\User;
       $users->name = $request->get("nama_user");
       $users->email = $request->get("email");
       $users->level = json_encode($request->get("roles"));
       $users->password = \Hash::make($request->get("password"));
       $users->avatar = "belum-punya.jpg";
       
       $users->save();
    }

    public function edit($id)
    {
        $users = \App\User::findOrFail($id);

        echo json_encode($users);
    }

    public function update(Request $request, $id)
    {
        $users = \App\User::findOrFail($id);
        $users->name = $request->get("nama_user");
        $users->email = $request->get("email");
        $users->level = json_encode($request->get("roles"));
        if(!empty($request->get("password")))
        {
            $users->password = $request->get("password");
        }
        $users->save();
    }

    public function destroy($id)
    {
        $user = \App\User::findOrFail($id);
        $user->delete();   
    }

    public function profile()
    {
        $user = \Auth::user();

        return view('users.profile',['user'=>$user]);
    }

    public function changeProfile(Request $request,$id){
        $this->validate($request, [
            'avatar' => 'file|image|mimes:jpeg,png,jpg'
        ]);

        $msg ="success";
        $user = \App\User::findOrFail($id);
        if(!empty($request->get('password'))){
            if(\Hash::check($request->get('old_password'),$user->password)){
                $user->password = \Hash::make($request->get('password'));
            }else{
                $msg = "error";
            }
        }
        $user->name = $request->get('nama');
        if($request->file('avatar')){
            if($user->avatar && file_exists('avatar/'.$user->avatar)){
                File::delete('avatar/'.$user->avatar);
            }
            $file = $request->file('avatar');
            $nama_file = time()."_".$file->getClientOriginalName();
            $tujuan_upload = 'avatar';
            $file->move($tujuan_upload,$nama_file);
            //$files = $file->store('avatar/public');
            $user->avatar = $nama_file;
        }

        $user->save();
        echo json_encode(array('msg'=>$msg, 'url' => asset('avatar/'.$user->avatar) ));
        
    }
}
