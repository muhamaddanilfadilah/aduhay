<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;


 // atau sesuai dengan namespace yang benar


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $orders=Order::with('user')->simplePaginate(10);
        return view('order.kasir.index', compact("orders"));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_customer' =>'required|max:50',
            'medicines' => 'required',
        ]);
        $arrayDistinct = array_count_values($request->medicines);
        // menyiapkan array kosong untuk menampung format array baru
        $arrayMedicines = [];

        foreach($arrayDistinct as $id => $count){
            $medicines = Medicine::where('id', $id)->first();

            if ($medicines['stock'] < $count) {
                $msg = "Obat " . $medicines['name'] . " sisa stock : " . $medicines['stock'] . " .Tidak dapat melakukan proses pembelian";
                return redirect()->back()->withInput()->with('failed', $msg);
            }

            $subPrice = $medicines['price'] * $count;

            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicines['name'],
                "qty" => $count,
                "price" => $medicines['price'],
                "sub_price" => $subPrice,
            ];

            array_push($arrayMedicines, $arrayItem);
        }

        $totalPrice = 0;

        foreach($arrayMedicines as $item){
            $totalPrice += (int)$item['sub_price'];
        }

        // harga total price ditambah 10%
        $pricePpn = $totalPrice + ($totalPrice * 0.01);

        $proses = order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $pricePpn
        ]);

        if($proses){
            $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->first();

            return redirect()->route('print', $order['id']);

        } else {

            return redirect()->back()->with('failed', 'gagal membuat data pembelian, silahkan coba kembali dengan data yang sesuai');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        ($order);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
     
    }

    public function downloadPdf($id){
        //ambil data berdasatkan id yang ada di struk dan dipastikan terformat array
        $order = Order::find($id)->toArray();
        //kita akan share data dengan inisial awal agar bisa digunakan ke blade manapun
        view()->share('order', $order);
        //ini akan meload view halaman downloadnya 
        $pdf = FacadePdf::loadView('order.kasir.download-pdf', $order);

        return $pdf->download('invoice.pdf');
    }
}
