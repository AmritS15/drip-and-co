@extends('layouts.admin')
@section('content')
<div class="main-content-inner">
                            <div class="main-content-wrap">
                                <div class="flex items-center flex-wrap justify-between gap20 mb-27">
                                    <h3>All Products</h3>
                                    <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                                        <li>
                                            <a href="{{ route('admin.index') }}">
                                                <div class="text-tiny">Dashboard</div>
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icon-chevron-right"></i>
                                        </li>
                                        <li>
                                            <div class="text-tiny">All Products</div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="wg-box">
                                    <div class="flex items-center justify-between gap10 flex-wrap">
                                        <div class="wg-filter flex-grow">
                                            <form class="form-search form-search-products" method="GET" action="{{ route('admin.products') }}">
                                                <fieldset class="name">
                                                    <input type="text" id="products-search-name" placeholder="Search by product name..." name="name"
                                                        value="{{ request('name') }}" autocomplete="off">
                                                </fieldset>
                                                <fieldset class="status">
                                                    <select name="collection" id="products-filter-collection">
                                                        <option value="">All collections</option>
                                                        @foreach ($brands as $brand)
                                                            <option value="{{ $brand->id }}" {{ request('collection') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </fieldset>
                                                <div class="button-submit">
                                                    <button type="submit" title="Search"><i class="icon-search"></i></button>
                                                </div>
                                            </form>
                                        </div>
                                        <a class="tf-button style-1 w208" href="{{ route('admin.product.add') }}"><i
                                                class="icon-plus"></i>Add new</a>
                                    </div>
                                    <div class="table-responsive">
                                        @if(Session::has('status'))
                                            <p class="alert alert-success">{{ Session::get('status') }}</p>
                                        @endif
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Price</th>
                                                    <th>SalePrice</th>
                                                    <th>SKU</th>
                                                    <th>Category</th>
                                                    <th>Collection</th>
                                                    <th>Featured</th>
                                                    <th>Stock</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                <tr>
                                                    <td>{{$product->id}}</td>
                                                    <td class="pname">
                                                        <div class="image">
                                                            <img src="{{ asset('uploads\products\thumbnails') }}/{{ $product->image }}" alt="{{ $product->name }}" class="image">
                                                        </div>
                                                        <div class="name">
                                                            <a href="#" class="body-title-2">{{$product->name}}</a>
                                                            <div class="text-tiny mt-3">{{$product->slug}}</div>
                                                        </div>
                                                    </td>
                                                    <td>{{$product->regular_price}}</td>
                                                    <td>{{$product->sale_price}}</td>
                                                    <td>{{$product->SKU}}</td>
                                                    <td>{{$product->category->name}}</td>
                                                    <td>{{$product->brand->name}}</td>
                                                    <td>{{$product->featured == 0 ? "No":"Yes"}}</td>
                                                    <td>{{$product->stock_status}}</td>
                                                    <td>{{$product->quantity}}</td>
                                                    <td>
                                                        <div class="list-icon-function">
                                                            <a href="#" target="_blank">
                                                                <div class="item eye">
                                                                    <i class="icon-eye"></i>
                                                                </div>
                                                            </a>
                                                            <a href="{{ route('admin.product.edit',['id'=>$product->id]) }}">
                                                                <div class="item edit">
                                                                    <i class="icon-edit-3"></i>
                                                                </div>
                                                            </a>
                                                            <form action="{{ route('admin.product.delete',['id'=>$product->id])}}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="item text-danger delete">
                                                                    <i class="icon-trash-2"></i>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="divider"></div>
                                    <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">

                                        {{ $products->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection

@push('scripts')
<script>
        $(function() {
            $('.delete').on('click',function(e){
                e.preventDefault();
                var form = $(this).closest('form');
                swal({
                    title: "Are you sure?",
                    text: "You want to delete this record?",
                    type:"warning",
                    buttons:["No","Yes"],
                    confirmButtonColor:'#dc3545'
                }).then(function(result){
                    if(result){
                        form.submit();
                    }
                });
            });

            (function() {
                var form = document.querySelector('.form-search-products');
                if (!form) return;
                var searchInput = form.querySelector('#products-search-name');
                var collectionSelect = form.querySelector('#products-filter-collection');
                var debounceTimer = null;
                var debounceMs = 200;

                function applySearch() {
                    var url = form.action || window.location.pathname;
                    var params = new URLSearchParams();
                    if (searchInput && searchInput.value.trim()) params.set('name', searchInput.value.trim());
                    if (collectionSelect && collectionSelect.value) params.set('collection', collectionSelect.value);
                    var qs = params.toString();
                    window.location.href = qs ? url + '?' + qs : url;
                }

                if (collectionSelect) {
                    collectionSelect.addEventListener('change', applySearch);
                }

                if (searchInput) {
                    searchInput.addEventListener('input', function() {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(applySearch, debounceMs);
                    });
                    searchInput.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            clearTimeout(debounceTimer);
                            applySearch();
                        }
                    });
                }
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    clearTimeout(debounceTimer);
                    applySearch();
                });
            })();
        });
    </script>
@endpush