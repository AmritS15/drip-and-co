@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
        <div class="main-content-wrap">
            <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                <h3>Orders</h3>
                <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                    <li>
                        <a href="{{route('admin.index')}}">
                            <div class="text-tiny">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <i class="icon-chevron-right"></i>
                    </li>
                    <li>
                        <div class="text-tiny">Orders</div>
                    </li>
                </ul>
            </div>

            <div class="wg-box">
                <div class="flex items-center justify-between gap10 flex-wrap">
                    <div class="wg-filter flex-grow">
                        <form class="form-search form-search-orders" method="GET" action="{{ route('admin.orders') }}">
                            <fieldset class="name">
                                <input type="text" id="orders-search-name" placeholder="Search here..." class="" name="name"
                                    tabindex="2" value="{{ request('name') }}" aria-required="true" autocomplete="off">
                            </fieldset>

                            <fieldset class="status">
                                <select name="status" id="orders-filter-status">
                                    <option value="" {{ request('status') === null ? 'selected' : '' }}>All
                                    </option>
                                    <option value="ordered" {{ request('status') === 'ordered' ? 'selected' : '' }}>
                                        Ordered</option>
                                    <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="canceled" {{ request('status') === 'canceled' ? 'selected' : '' }}>
                                        Canceled</option>
                                </select>
                            </fieldset>

                            <div class="button-submit">
                                <button class="" type="submit"><i class="icon-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="wg-table table-all-user">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:70px">OrderNo</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Subtotal</th>
                                    <th class="text-center">Tax</th>
                                    <th class="text-center">Total</th>

                                    <th class="text-center">Status</th>
                                    <th class="text-center">Order Date</th>
                                    <th class="text-center">Total Items</th>
                                    <th class="text-center">Delivered On</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                <tr>
                                    <td class="text-center">{{$order->id}}</td>
                                    <td class="text-center">{{$order->name}}</td>
                                    <td class="text-center">{{$order->phone}}</td>
                                    <td class="text-center">£{{$order->subtotal}}</td>
                                    <td class="text-center">£{{$order->tax}}</td>
                                    <td class="text-center">£{{$order->total}}</td>
                                    <td class="text-center">  
                                    @if($order->status == 'delivered')
                                        <span class="badge bg-success">Delivered</span>
                                    @elseif($order->status == 'canceled')
                                        <span class="badge bg-danger">Canceled</span>
                                    @else
                                        <span class="badge bg-warning">Ordered</span>
                                    @endif
                                </td>
                                    <td class="text-center">{{$order->created_at}}</td>
                                    <td class="text-center">{{$order->orderItems->count()}}</td>
                                    <td class="text-center">{{$order->delivered_date}}</td>
                                    <td class="text-center">
                                        <a href="{{route('admin.order.details',['order_id'=>$order->id])}}">
                                            <div class="list-icon-function view-icon">
                                                <div class="item eye">
                                                    <i class="icon-eye"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="divider"></div>
                <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                    {{ $orders->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <script>
        (function() {
            var form = document.querySelector('.form-search-orders');
            if (!form) return;

            var statusSelect = form.querySelector('#orders-filter-status');
            var searchInput = form.querySelector('#orders-search-name');
            var debounceTimer = null;
            var debounceMs = 200;

            function applyFilters() {
                var url = form.action || window.location.pathname;
                var params = new URLSearchParams();
                if (searchInput && searchInput.value.trim()) params.set('name', searchInput.value.trim());
                if (statusSelect && statusSelect.value) params.set('status', statusSelect.value);
                var qs = params.toString();
                window.location.href = qs ? url + '?' + qs : url;
            }

            if (statusSelect) {
                statusSelect.addEventListener('change', applyFilters);
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(applyFilters, debounceMs);
                });
                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        clearTimeout(debounceTimer);
                        applyFilters();
                    }
                });
            }

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                clearTimeout(debounceTimer);
                applyFilters();
            });
        })();
    </script>
@endsection