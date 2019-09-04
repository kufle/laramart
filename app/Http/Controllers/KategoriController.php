<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('kategori.index');
    }

    public function listData()
    {
        $kategori = \App\Kategori::orderBy('id_category','desc')->get();

        $no =0;
        $data = array();
        foreach($kategori as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->category_name;
            $row[] = '<div class="d-flex">
                        <a href="javascript:void(0)" onclick="editForm('.$list->id_category.')" class="btn btn-primary btn-sm mr-2"><i class="fas fa-pencil-alt"></i></a>
                        <a href="javascript:void(0)" onclick="deleteData('.$list->id_category.')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a> 
                    </div>';
           $data[] = $row;       
        }
        $output = array("data" => $data);

        return response()->json($output);
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
        \Validator::make($request->all(),[
            "category_name" => "required",
        ])->validate();
        $kategori = new \App\Kategori;

        $kategori->category_name = $request->get('category_name');

        $kategori->save();
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = \App\Kategori::findOrFail($id);
        echo json_encode($kategori);
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
        $kategori = \App\Kategori::findOrFail($id);
        $kategori->category_name = $request->get("category_name");
        $kategori->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = \App\Kategori::findOrFail($id);

        $kategori->delete();
    }
}
