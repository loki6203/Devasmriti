<?php

namespace App\Exports;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\Relation;
use App\Models\Order;
use App\Models\OrderSeva;
use App\Models\SevaPrice;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportOrder implements FromView //FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::all();
    }
	
	public function headings(): array
    {
        return ["Name", "Email", "Address", "Created At"];
    }
	
	public function view_old(): View
    {	
		$orders = Order::with('order_sevas')->with('user')->with('user_address')->with('user_billing')->with('seva_coupon')->get();
		$order_sevas = OrderSeva::with('seva_price')->get()->toArray();
		//dd($order_sevas);
		$order_wise_sevas=array();
		foreach($order_sevas as $os) {
			//dd($os);
			if(!isset($order_wise_sevas[$os['order_id']])) $order_wise_sevas[$os['order_id']]=array();
			$order_wise_sevas[$os['order_id']][]=$os;
		} //dd($order_wise_sevas);
		//dd($orders);
		//dd(Order::with('order_sevas')->get());
        return view('exports.orders_old', ['order' => $orders, 'order_wise_sevas' => $order_wise_sevas]);
    }
	
	public function view(): View
    {	
		$order_sevas = OrderSeva::with('Order')->with('seva_price')->with('Order.user')->with('Order.user_address')->with('Order.user_address.Country')->with('Order.user_address.State')->with('Order.user_address.City')->with('Order.user_billing')->with('Order.seva_coupon')->with('userFamilyDetail')->with('userFamilyDetail.relation')->get();
        return view('exports.orders', ['order_sevas' => $order_sevas]);
    }
	
}
