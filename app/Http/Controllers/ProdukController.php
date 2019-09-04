<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Produk;
use App\Kategori;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $kategori = Kategori::all();
        return view('produk.index',["category" => $kategori]);
    }

    public function listData()
    {
        $produk = Produk::with("category")->orderBy('product.id_product','desc')->get();
        $no = 0;
        $data = array();
        foreach($produk as $list){
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="id[]" id="id[]" value='.$list->id_product.'>';
            $row[] = $no;
            $row[] = $list->code_product;
            $row[] = $list->product_name;
            $row[] = $list->category->category_name;
            $row[] = $list->merk;
            $row[] = "Rp. ".format_uang($list->harga_beli);
            $row[] = "Rp. ".format_uang($list->harga_jual);
            $row[] = $list->diskon."%";
            $row[] = $list->stock;
            $row[] = "<div class='d-flex'>
                        <a href='javascript:void(0)' onclick='editForm(".$list->id_product.")' class='btn btn-primary btn-sm mr-2'><i class='fas fa-pencil-alt'></i></a>
                        <a href='javascript:void(0)' onclick='deleteData(".$list->id_product.")' class='btn btn-danger btn-sm mr-2'><i class='fas fa-trash'></i></a>
                     </div>";
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
        $kode = Produk::where('code_product',$request->get('kode'))->count();

        if($kode < 1){
            $product = new Produk;
            $product->code_product = $request->get("kode");
            $product->product_name = $request->get("nama");
            $product->merk = $request->get("merk");
            $product->harga_beli = $request->get("harga_beli");
            $product->diskon = $request->get("diskon");
            $product->harga_jual = $request->get("harga_jual");
            $product->stock = $request->get("stok");
            $product->id_category = $request->get("kategori");
            $product->save();
            echo json_encode(array("msg"=>"success"));
        }else{
            echo json_encode(array("msg"=>"error"));
        }
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
        $produk = Produk::findOrFail($id);
        echo json_encode($produk);
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
        $produk = Produk::findOrFail($id);

        $produk->product_name = $request->get("nama");
        $produk->id_category = $request->get("kategori");
        $produk->merk = $request->get("merk");
        $produk->harga_beli = $request->get("harga_beli");
        $produk->diskon = $request->get("diskon");
        $produk->harga_jual = $request->get('harga_jual');
        $produk->stock = $request->get('stok');
        $produk->save();
        echo json_encode(array("msg"=>"success"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);

        $produk->delete();
    }

    public function deleteBatch(Request $request){
        $id_produk = $request->get("id");
        foreach($id_produk as $id){
            $produk = Produk::findOrFail($id);
            $produk->delete();
        }
    }

    public function cetakbarcode(Request $request){
        $dataproduk = array();
        $id_produk = $request->get("id");
        foreach($id_produk as $id){
            $produk = Produk::findOrFail($id);
            $dataproduk[] = $produk;
        }
        $no=1;
        $pdf = PDF::loadView('produk.barcode',['dataproduk'=>$dataproduk , 'no'=>$no]);
        $pdf->setPaper('a4','potrait');
        return $pdf->stream();
    }
}
