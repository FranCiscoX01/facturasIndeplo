<?php

namespace App\Http\Controllers;

use App\Order;
use App\Costumer;
use App\OrderItem;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('orders.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $costumers = Costumer::select('id', 'name', 'company_name')->where('status_id', '!=', 3)->get();
        $sections = Section::select('id', 'code', 'name', 'price')->where('status_id', '!=', 3)->get();

        return view('orders.create', [
            'costumers' => $costumers,
            'sections' => $sections
        ]);
    }
    public function getSectionByID(int $id)
    {
        $sections = Section::find($id);

        return response()->json(['data' => $sections]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'costumer' => 'required|int',
            'code' => 'required|string',
            'data.*' => 'required|array|min:1',
            'data.*.quantity.*' => 'required|array|min:1|int'
        ]);

        $data = $request->data;

        $order = Order::create([
            'costumer_id' => $request->costumer,
            'code' => $request->code,
            'date' => date('Y-m-d'),
            'status_id' => 1
        ]);

        

        $keys = $data['keys'];
        $quantities = $data['quantity'];
        $sections = $data['section'];

        for ($i=0; $i < count($keys); $i++) { 
            OrderItem::create([
                'order_id' => $order->id,
                'section_id' => $sections[$keys[$i]],
                'quantity' => $quantities[$keys[$i]],
                'status_id' => 1
            ]);
        }

        return response()->json(['response' => 200]);
    }

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->id);

        $order->status_id = $request->status;
        $order->save();

        return response()->json($order);
    }

    public function deleteOrderItem(int $id)
    {
        $order_item = OrderItem::find($id);

        $order_item->status_id = 3;
        $order_item->save();

        return response()->json($order_item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $orders = DB::table('orders as o')
                    ->join('costumers as c', 'c.id', '=', 'o.costumer_id')
                    ->where('o.status_id', '!=', 3)
                    ->select('c.name', 'c.company_name', 'c.id', 'o.id', 'o.code', 'o.date', 'o.status_id')
                    ->get();

        return response()->json(['order' => $orders]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('orders.edit', ['order_id' => $id]);
    }

    public function getCostumerSections()
    {
        $costumers = Costumer::select('id', 'name', 'company_name')->where('status_id', '!=', 3)->get();
        $sections = Section::select('id', 'code', 'name', 'price')->where('status_id', '!=', 3)->get();

        return response()->json([
            'costumers' => $costumers,
            'sections' => $sections
        ]);
    }

    public function getOrderDetails(int $id)
    {
        $order = DB::table('orders as o')
                    ->join('costumers as c', 'c.id', '=', 'o.costumer_id')
                    ->where('o.status_id', '!=', 3)
                    ->where('o.id', $id)
                    ->select('c.name', 'c.company_name', 'c.id as costumer_id', 'o.id as order_id', 'o.code', 'o.date', 'o.status_id')
                    ->limit(1)
                    ->get();

        $order_item = DB::table('orders as o')
                    ->join('costumers as c', 'c.id', '=', 'o.costumer_id')
                    ->join('order_item as oi', 'oi.order_id', '=', 'o.id')
                    ->join('sections as s', 'oi.section_id', '=', 's.id')
                    ->where('oi.status_id', '!=', 3)
                    ->where('o.id', $id)
                    ->select('oi.id as order_item_id', 'oi.section_id', 'oi.quantity', 's.code', 's.name', 's.price')
                    ->get();

        return response()->json([
            'order' => $order[0],
            'order_items' => $order_item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $order = Order::find($request->order['order_id']);

        $order->costumer_id = $request->order['costumer_id'];
        $order->code = $request->order['code'];
        $order->save();

        // delete old records for new
        OrderItem::where('order_id', $request->order['order_id'])->delete();

        // new records
        foreach ($request->order_items as $order_item) { 
            OrderItem::create([
                'order_id' => $order->id,
                'section_id' => $order_item['section_id'],
                'quantity' => $order_item['quantity'],
                'status_id' => 1
            ]);
        }

        return response()->json(['res' => 200]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
