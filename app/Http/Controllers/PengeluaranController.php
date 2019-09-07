<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengeluaranController extends Controller
{
    
    public function index()
    {
        return view('pengeluaran.index');
    }

    public function listData()
    {
        $pengeluaran = \App\Pengeluaran::orderBy("id_pengeluaran","DESC")->get();

        $data = array();
        $no = 0;
        foreach($pengeluaran as $list){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $list->jenis_pengeluaran;
            $row[] = "Rp. ".format_uang($list->nominal);
            $row[] = "<div class='d-flex'>
                        <a href='javascript:void(0)' class='btn btn-primary btn-sm mr-3' onclick='editForm(".$list->id_pengeluaran.")'><i class='fas fa-pencil-alt'></i></a>
                        <a href='javascript:void(0)' class='btn btn-danger btn-sm mr-3' onclick='deleteData(".$list->id_pengeluaran.")'><i class='fas fa-trash'></i></a>
                     </div>";
            $data[] = $row;
        }
        $output = array("data" => $data);

        return response()->json($output);
    }

    public function store(Request $request)
    {
        $pengeluaran = new \App\Pengeluaran;
        $pengeluaran->jenis_pengeluaran = $request->get("jenis_pengeluaran");
        $pengeluaran->nominal = $request->get("nominal");
        $pengeluaran->save();
    }

    public function edit($id)
    {
        $pengeluaran = \App\Pengeluaran::findOrFail($id);

        echo json_encode($pengeluaran);
    }

    public function update(Request $request, $id)
    {
        $pengeluaran = \App\Pengeluaran::findOrFail($id);
        $pengeluaran->jenis_pengeluaran = $request->get("jenis_pengeluaran");
        $pengeluaran->nominal = $request->get("nominal");
        $pengeluaran->save();
    }

    public function destroy($id)
    {
        $pengeluaran = \App\Pengeluaran::findOrFail($id);
        $pengeluaran->delete();
    }
}
