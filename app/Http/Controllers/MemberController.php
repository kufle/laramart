<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class MemberController extends Controller
{
    
    public function index()
    {
        return view("member.index");
    }

    public function listData()
    {
        $member = \App\Member::orderBy("id_member","DESC")->get();

        $data = array();
        $no = 0;
        foreach($member as $list){
            $no++;
            $row = array();
            $row[] = "<input type='checkbox' name='id[]' value=".$list->id_member.">";
            $row[] = $no;
            $row[] = $list->code_member;
            $row[] = $list->nama;
            $row[] = $list->alamat;
            $row[] = $list->telephone;
            $row[] = "<div class='d-flex'>
                        <a href='javascript:void(0)' class='btn btn-primary btn-sm mr-3' onclick='editForm(".$list->id_member.")'><i class='fas fa-pencil-alt'></i></a>
                        <a href='javascript:void(0)' class='btn btn-danger btn-sm' onclick='deleteData(".$list->id_member.")'><i class='fas fa-trash'></i></a>
                     </div>";
            $data[] = $row;
        }

        $output = array("data"=>$data);

        return response()->json($output);

    }
    
    public function store(Request $request)
    {   
        $jum = \App\Member::where("code_member",$request->get("code_member"))->count();
        
        if($jum < 1){
            $member = new \App\Member;
            $member->code_member = $request->get("code_member");
            $member->nama = $request->get("nama");
            $member->alamat = $request->get("alamat");
            $member->telephone = $request->get("telepon");
            $member->save();

            echo json_encode(array("msg" => "success"));
        }else{
            echo json_encode(array("msg" => "error"));
        }
        
    }

    public function edit($id)
    {
        $member = \App\Member::findOrFail($id);

        echo json_encode($member);
    }
    
    public function update(Request $request, $id)
    {
        $member = \App\Member::findOrFail($id);

        $member->nama = $request->get("nama");
        $member->alamat = $request->get("alamat");
        $member->telephone = $request->get("telepon");

        $member->save();

        echo json_encode(array("msg"=>"success"));
    }

    public function destroy($id)
    {
        $member = \App\Member::findOrFail($id);
        $member->delete();
    }

    public function deleteBatch(Request $request){
        $id_member = $request->get("id");
        foreach($id_member as $id){
            $member = \App\Member::findOrFail($id);
            $member->delete();
        }
    }

    public function printCard(Request $request)
    {
        $datamember = array();
        foreach($request->get('id') as $id){
            $member = \App\Member::findOrFail($id);
            $datamember[] = $member;
        }
        $pdf = PDF::loadView('member.card',['member'=>$datamember]);
        $pdf->setPaper(array(0,0,566.93,850.39),'potrait');
        return $pdf->stream();
    }
}
