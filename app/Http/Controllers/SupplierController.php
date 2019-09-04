<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("supplier.index");
    }

    public function listData(){
        $supplier = \App\Supplier::orderBy('id_supplier','DESC')->get();
        $no = 0;
        $data = array();
        foreach($supplier as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->nama;
            $row[] = $list->alamat;
            $row[] = $list->telepon;
            $row[] = "<div class='d-flex'>
                        <a href='javascript:void(0)' onclick='editForm(".$list->id_supplier.")' class='btn btn-primary btn-sm mr-2'><i class='fas fa-pencil-alt'></i></a>
                        <a href='javascript:void(0)' onclick='deleteData(".$list->id_supplier.")' class='btn btn-danger btn-sm'><i class='fas fa-trash'></i></a>
                     </div>";
            $data[] = $row;
        }
        $output = array("data" => $data);
        return response()->json($output);        
    }

    public function store(Request $request)
    {
        $supplier = new \App\Supplier;

        $supplier->nama = $request->get("nama");
        $supplier->telepon = $request->get("telepon");
        $supplier->alamat = $request->get("alamat");

        $supplier->save();
    }

    public function edit($id)
    {
        $supplier = \App\Supplier::findOrFail($id);

        echo json_encode($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = \App\Supplier::findOrFail($id);

        $supplier->nama = $request->get("nama");
        $supplier->telepon = $request->get("telepon");
        $supplier->alamat = $request->get("alamat");

        $supplier->save();
    }

    
    public function destroy($id)
    {
        $supplier = \App\Supplier::findOrFail($id);

        $supplier->delete();
    }
}
