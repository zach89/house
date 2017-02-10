<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Customer;
use App\Invoice;
use App\InvoiceItem;
class InvoiceController extends Controller
{
    public function index()
    {
    	return response()
    		->json([
    			'model' => Invoice::with('customer')->filterPaginateOrder()
    		]);
    }
    public function create()
    {
    	return response()->json([
    			'form' => Invoice::initialize(),
    			'option' => [
    				'customers' => Customer::orderBy('name')->get()
    			]
    		]);
    }
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'customer_id' => 'required|exists:customers,id',
    		'title' => 'required',
    		'date' => 'required|date_formate:Y-m-d',
    		'due_data' => 'required|date_formate:Y-m-d',
    		'discount' => 'required|numberic|min:0',
    		'items' => 'required|array|min:1',
    		'items.*.description' => 'required|max:255',
    		'items.*.qty' => 'required|integer|min:1',
    		'items.*.unit_price' => 'required|numberic|min:0',
    	]);
    	$items = [];
    	$data = $request->except('items');
    	$data['sub_total'] = 0;
    	foreach($request->items as $item) {
    		$data['sub_total'] += $item['unit_price'] * $item['qty'];
    		$items[] = new InvoiceItem($item);
    	}
    	$data['total'] = $data['sub_total'] - $data['discount'];

    	$invoice = Invoice::create($data);
    	$invoice->items()->saveMany($item);
    	return response()->json([
    			'saved' => true
    		]);
    }
    public function show($id)
    {
    	$invoice = Invoice::with('customer','items')->findOrFail($id);

    	return response()->json([
    			'model' => $invoice
    		]);
    }
    public function edit($id)
    {
    	$invoice = Invoice::with('items')->findOrFail($id);

    	return response()->json([
    			'form' => $invoice,
                'option' => [
                    'customers' => Customer::orderBy('name')->get()
                ]
    		]);
    }
    public function update(Request $request, $id)
    {
    	$this->validate($request, [
    		'customer_id' => 'required|exists:customers,id',
    		'title' => 'required',
    		'date' => 'required|date_formate:Y-m-d',
    		'due_data' => 'required|date_formate:Y-m-d',
    		'discount' => 'required|numberic|min:0',
    		'items' => 'required|array|min:1',
    		'items.*.description' => 'required|max:255',
    		'items.*.qty' => 'required|integer|min:1',
    		'items.*.unit_price' => 'required|numberic|min:0',
    	]);
    	$invoice =Invoice::findOrFail($id);
    	$data = $request->except('items');
    	$data['sub_total'] = 0;
    	$items = [];
    	$itemIds = [];

    	foreach($request->items as $item) {
    		$data['sub_total'] += $item['unit_price'] * $item['qty'];
    		if(isset($item['id'])) {
    			InvoiceItem::whereId($item['id'])
    				->whereInvoiceId($invoice->id)
    				->update($item);
    		} else {
    			$items[] = new InvoiceItem($item);
    		}
    	}
    	$data['total'] = $data['sub_total'] - $data['discount'];

    	if (count($itemIds)) {
    		InvoiceItem::whereInvoiceId($invoice->id)
    			->whereNotIn('id',$itemIds)
    			->delete();
    	}

    	if (count($item)) {
    		$invoice->items()
    			->saveMany($items);
    	}
    	$invoice->update($data);
    	return response()->json([
    			'updated' => true
    		]);
    }
    public function destroy($id)
    {
    	$invoice = Invoice::findOrFail($id);

    	InvoiceItem::whereInvoiceId($invoice->$id)
    		->delete();
    	$invoice->delete();

    	return response()->json([
    			"deleted" => true
    		]);
    }
}
