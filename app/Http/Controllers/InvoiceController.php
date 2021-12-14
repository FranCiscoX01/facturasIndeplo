<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.index');
    }

    public function getAllInvoices()
    {
        $invoices = DB::table('invoice as i')
                    ->join('orders as o', 'o.id', '=', 'i.order_id')
                    ->join('costumers as c', 'c.id', '=', 'o.costumer_id')
                    ->where('i.status_id', '!=', 3)
                    ->select('o.code as code_order', 'c.name', 'c.company_name', 'i.code as code_invoice', 'i.date', 'i.id', 'i.status_id', 'i.file')
                    ->get();


        return response()->json(['invoices' => $invoices]);
    }

    public function getAllOrders()
    {
        $orders = DB::table('orders as o')
                    ->join('costumers as c', 'c.id', '=', 'o.costumer_id')
                    ->where('o.status_id', '!=', 3)
                    ->select('c.name', 'c.company_name', 'c.id as costumer_id', 'o.id as order_id', 'o.code')
                    ->get();

        return response()->json(['orders' => $orders]);
    }

    public function uploadFile(Request $request)
    {
        $file = $request->file('file');
    
        //Display File Name
        // $name = $file->getClientOriginalName();
    
        //Display File Extension
        $extension = $file->getClientOriginalExtension();

        //Uid
        $uid = $request['dataFile'];

        //Folder
        $folder = $request['folder'];
    
        //Display File Real Path
        // $path = $file->getRealPath();
    
        //Display File Size
        // $size = $file->getSize();
    
        //Display File Mime Type
        // $mime = $file->getMimeType();

        //Nombre a guardar
        $fileName = $uid.'.' . $extension;

        $upload_path = public_path('upload');
        $file_name = $request->file->getClientOriginalName();
        $generated_new_name = time() . '.' . $request->file->getClientOriginalExtension();
        $path = $request->file->move($upload_path, $fileName);

        // public/upload/

        //Path donde se guardara provisionalmente
        // Storage::disk('local')->makeDirectory('tmp/'.$folder);
        // $path = storage_path('/tmp/'.$folder.'/'.$fileName);

        // $urlPicture = asset(Storage::disk('local')->url('tmp/'.$folder.'/'.$fileName));

        // //Si la imagen se debe subir ya sin ninguna otro requerimiento
        // if($request['tmp']==1){
        //     $urlPicture =  $this->uploadInServer($uid,$folder,$fileName);
        // }

        return $fileName;
    }

    public function deleteVoucher(Request $request)
    {
        $path = public_path('upload/'.$request['uid'].".pdf");
        unlink($path);
    }

    static function uploadInServer($uid,$folder,$fileName){
        $path = storage_path('/tmp/'.$folder.'/'.$fileName);
        $file = Storage::path($path);
        $file = fopen($path,'r+');
        Storage::disk('public')->makeDirectory('voucher/'.$folder);
        Storage::disk('public')->put('voucher/'.$folder.'/'.$fileName,$file); 
        fclose($file);
        Storage::disk('local')->delete('tmp/'.$folder.'/'.$fileName.'');
        
        return '/voucher/'.$folder.'/'.$fileName;
    }

    public function getDownload(string $file_name)
    {
        //PDF file is stored under project/public/download/info.pdf
        $file= public_path(). "/upload/" . $file_name;

        $headers = [
            'Content-Type' => 'application/pdf',
        ];
    
        return response()->download($file, 'comprobante.pdf', $headers);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file == "")
            $request->file = NULL;

        $invoice = Invoice::create([
            'code' => $request->data['code'],
            'order_id' => $request->data['order_id'],
            'file' => $request->file,
            'date' => date('Y-m-d'),
            'status_id' => 1
        ]);

        return response()->json(['res' => 200]);
    }

    public function changeStatus(Request $request)
    {
        $invoice = Invoice::find($request->id);

        $invoice->status_id = $request->status;
        $invoice->save();

        return response()->json($invoice);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('invoices.edit', ['invoice_id' => $id]);
    }

    public function getInvoiceById(int $id)
    {
        $invoice = Invoice::find($id);

        return response()->json(['res' => $invoice]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = Invoice::find($request->data['id'])->update([
            'code' => $request->data['code'],
            'order_id' => $request->data['order_id'],
            'file' => $request->file,
        ]);

        return response()->json(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
