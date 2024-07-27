use Illuminate\Pagination\LengthAwarePaginator;

/* get invoice list */
$invoiceList = Invoice::where($where)->get();

/* get client list */
$clientList = DB::table('invoices')
    ->where($where)->whereNull('deleted_at')
    ->select('email')->groupBy('email')
    ->get()->toArray();

/* custom pagination */
$perPage      = 1;
$currentPage  = LengthAwarePaginator::resolveCurrentPage();
$currentItems = array_slice($clientList, $perPage * ($currentPage - 1), $perPage);
$paginator    = new LengthAwarePaginator($currentItems, count($clientList), $perPage, $currentPage, ['path' => $request->url()]);
$results      = $paginator->appends(request()->query());

/* set data */
if (!empty($results)) {
    foreach ($results as $row) {

        $totalPaid   = $invoiceList->where('email', $row->email)->where('status', 'paid')->sum('grand_total');
        $totalUnpaid = $invoiceList->where('email', $row->email)->where('status', 'unpaid')->sum('grand_total');
        $totalDelete = $invoiceList->where('email', $row->email)->where('status', 'delete')->sum('grand_total');

        // get last order data
        $orderInfo     = Order::where('email', $row->email)->orderBy('id', 'desc')->first();
        $lastOrderDate = (!empty($orderInfo) ? $orderInfo->created : '');

        // get live links
        $totalLiveLink = 0;
        $orderIdList   = Invoice::where('email', $row->email)->where('status', 'paid')->pluck('order_id')->toArray();
        if (!empty($orderIdList)) {
            foreach ($orderIdList as $value) {

                $liveLink = DB::table('order_items')->join('orders', 'order_items.order_id', 'orders.id')
                    ->whereNull('order_items.deleted_at')->where('orders.status', 'paid')
                    ->whereIn('orders.id', json_decode($value))->count();

                $totalLiveLink += $liveLink;
            }
        }

        $row->paid            = $totalPaid;
        $row->unpaid          = $totalUnpaid;
        $row->delete          = $totalDelete;
        $row->live_links      = $totalLiveLink;
        $row->last_order_date = $lastOrderDate;
    }
}
