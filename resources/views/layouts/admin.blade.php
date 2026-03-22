<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="author" content="team17" />
 <link rel="stylesheet" type="text/css" href="{{ asset('css/animate.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}?v={{ file_exists(public_path('css/style.css')) ? filemtime(public_path('css/style.css')) : 1 }}">
    <link rel="stylesheet" href="{{ asset('font/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('icon/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('images/favicon.ico') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}?v={{ file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : 1 }}">
    <style>
        html[data-theme="dark"] .wgp-pagination .pagination .page-link {
            color: #e9ecef !important;
            background-color: #2b2f33 !important;
            border-color: #5e656d !important;
        }
        html[data-theme="dark"] .wgp-pagination .pagination .page-item.active .page-link {
            color: #ffffff !important;
            background-color: #141618 !important;
            border-color: #141618 !important;
        }
        html[data-theme="dark"] .wgp-pagination .pagination .page-item.disabled .page-link {
            color: #9aa3ad !important;
            background-color: #22262a !important;
            border-color: #4f565e !important;
            opacity: 1 !important;
        }
        html[data-theme="dark"] .wgp-pagination .pagination a.page-link:hover,
        html[data-theme="dark"] .wgp-pagination .pagination a.page-link:focus {
            color: #ffffff !important;
            background-color: #33383d !important;
            border-color: #6a727a !important;
        }
        html[data-theme="dark"] .wgp-pagination .text-muted {
            color: #adb5bd !important;
        }
        /*
         * Dark mode fixes inlined so they apply on deploy even when public/css is CDN-cached.
         * Mirrors public/css/style.css — coupon expiry date + wg-box search icon.
         */
        html[data-theme="dark"] .section-content-right input[type="date"],
        html[data-theme="dark"] .section-content-right input[type="datetime-local"],
        html[data-theme="dark"] .section-content-right input[type="month"],
        html[data-theme="dark"] .section-content-right input[type="time"],
        html[data-theme="dark"] .section-content-right input[type="week"] {
            background-color: #111827 !important;
            border-color: #374151 !important;
            color: #ffffff !important;
            -webkit-text-fill-color: #ffffff !important;
        }
        html[data-theme="dark"] .section-content-right input[type="date"]::-webkit-calendar-picker-indicator,
        html[data-theme="dark"] .section-content-right input[type="datetime-local"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 0.9;
        }
        html[data-theme="dark"] .section-content-right .wg-box .form-search .button-submit button,
        html[data-theme="dark"] .section-content-right .wg-box .form-search .button-submit button i {
            color: #ffffff !important;
        }
        html[data-theme="dark"] .section-content-right .wg-box .form-search .button-submit button:hover,
        html[data-theme="dark"] .section-content-right .wg-box .form-search .button-submit button:hover i {
            color: #ffffff !important;
            opacity: 0.9;
        }
        html[data-theme="dark"] .section-content-right .header-dashboard .form-search .button-submit button,
        html[data-theme="dark"] .section-content-right .header-dashboard .form-search .button-submit button i {
            color: #e5e7eb !important;
        }
    </style>
    @stack("styles")
</head>
<body class="body">
    <symbol id="icon_user" viewBox="0 0 20 20">
      <g clip-path="url(#clip0_6_29)">
        <path
          d="M10 11.2652C3.99077 11.2652 0.681274 14.108 0.681274 19.2701C0.681274 19.6732 1.00803 20 1.4112 20H18.5888C18.992 20 19.3187 19.6732 19.3187 19.2701C19.3188 14.1083 16.0093 11.2652 10 11.2652ZM2.16768 18.5402C2.45479 14.6805 5.08616 12.7251 10 12.7251C14.9139 12.7251 17.5453 14.6805 17.8326 18.5402H2.16768Z"
          fill="currentColor" />
        <path
          d="M10 0C7.23969 0 5.1582 2.12336 5.1582 4.93895C5.1582 7.83699 7.33023 10.1944 10 10.1944C12.6698 10.1944 14.8419 7.83699 14.8419 4.93918C14.8419 2.12336 12.7604 0 10 0ZM10 8.7348C8.13508 8.7348 6.61805 7.03211 6.61805 4.93918C6.61805 2.92313 8.04043 1.45984 10 1.45984C11.9283 1.45984 13.382 2.95547 13.382 4.93918C13.382 7.03211 11.865 8.7348 10 8.7348Z"
          fill="currentColor" />
      </g>
      <defs>
        <clipPath id="clip0_6_29">
          <rect width="20" height="20" fill="white" />
        </clipPath>
      </defs>
    </symbol>
    <div id="wrapper">
        <div id="page" class="">
            <div class="layout-wrap">

                

                <div class="section-menu-left">
                    <div class="box-logo">
                        <a href="{{route('home.index')}}" id="site-logo-inner">
                            <img class="" id="logo_header_1" alt="" src="{{ asset('images/logo/logo.png') }}"
                                data-light="{{ asset('images/logo/logo.png') }}" data-dark="{{ asset('images/logo/logo.png') }}">
                        </a>
                        <div class="button-show-hide">
                            <i class="icon-menu-left"></i>
                        </div>
                    </div>
                    <div class="center">
                        <div class="center-item">
                            <div class="center-heading">Main Home</div>
                            <ul class="menu-list">
                                <li class="menu-item">
                                    <a href="{{route('admin.index')}}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Dashboard</div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="center-item">
                            <ul class="menu-list">
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-shopping-cart"></i></div>
                                        <div class="text">Products</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.product.add') }}" class="">
                                                <div class="text">Add Product</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{ route('admin.products') }}" class="">
                                                <div class="text">Products</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Category</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.category.add')}}" class="">
                                                <div class="text">New Category</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.categories')}}" class="">
                                                <div class="text">Categories</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-layers"></i></div>
                                        <div class="text">Collection</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.brand.add')}}" class="">
                                                <div class="text">New Collection</div>
                                            </a>
                                        </li>
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.brands')}}" class="">
                                                <div class="text">Collections</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item has-children">
                                    <a href="javascript:void(0);" class="menu-item-button">
                                        <div class="icon"><i class="icon-file-plus"></i></div>
                                        <div class="text">Order</div>
                                    </a>
                                    <ul class="sub-menu">
                                        <li class="sub-menu-item">
                                            <a href="{{route('admin.orders')}}" class="">
                                                <div class="text">Orders</div>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu-item">
                                    <a href="{{ route('admin.slides') }}" class="">
                                        <div class="icon"><i class="icon-image"></i></div>
                                        <div class="text">Slides</div>
                                    </a>
                                </li>
                                <li class="menu-item">
                                    <a href="{{route('admin.coupons')}}" class="">
                                        <div class="icon"><i class="icon-grid"></i></div>
                                        <div class="text">Coupons</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                    <a href="{{route('admin.contacts')}}" class="">
                                        <div class="icon"><i class="icon-mail"></i></div>
                                        <div class="text">Messages</div>
                                    </a>
                                </li>

                                <li class="menu-item">
                                   <a href="{{ route('admin.users') }}">
                                        <div class="icon"><i class="icon-user"></i></div>
                                        <div class="text">User</div>
                                    </a>
                                </li>

                                 <li class="menu-item">
                                    <form method="POST" action="{{ route('logout')}}" id="logout-form">
                                        @csrf
                                    <a href="{{ route('logout')}}" class=""onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        <div class="icon"><i class="icon-settings"></i></div>
                                        <div class="text">Logout</div>
                                    </a>
                                    </form>
                                </li>
                            
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="section-content-right">

                    <div class="header-dashboard">
                        <div class="wrap">
                            <div class="header-left">
                                <a href="{{route('home.index')}}">
                                    <img class="" id="logo_header_mobile" alt="" src="{{ asset('images/logo/logo.png') }}"
                                        data-light="{{ asset('images/logo/logo.png') }}" data-dark="{{ asset('images/logo/logo.png') }}"
                                        data-width="154px" data-height="52px" data-retina="{{ asset('images/logo/logo.png') }}">
                                </a>
                                <div class="button-show-hide">
                                    <i class="icon-menu-left"></i>
                                </div>


                                <form class="form-search flex-grow">
                                    <fieldset class="name">
                                        <input type="text" placeholder="Search here..." class="show-search" name="name" id="search-input" tabindex="2" value="" aria-required="true" required="" autocomplete="off">
                                    </fieldset>
                                    <div class="button-submit">
                                        <button class="" type="submit"><i class="icon-search"></i></button>
                                    </div>
                                    <div class="box-content-search">    
                                        <ul id="box-content-search">
                                        </ul>
                                    </div>
                                </form>

                            </div>
                            <div class="header-grid">

                                <div class="popup-wrap user type-header d-flex align-items-center gap-3">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="header-user wg-user">
                                                <svg class="" width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <use href="#icon_user" />
                                                </svg>
                                                <span class="flex flex-column">
                                                    <span class="body-title mb-2">{{ Auth::user()->name}}</span>
                                                    <span class="text-tiny">Admin</span>
                                                </span>
                                            </span>
                                        </button>
                                    </div>

                                    <a href="#" class="header-toolsitem header-toolstheme js-theme-toggle"
                                        title="Toggle theme">
                                        <svg class="theme-icon-sun" width="20" height="20" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path
                                                d="M10 2a1 1 0 011 1v1a1 1 0 01-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1z" />
                                        </svg>
                                        <svg class="theme-icon-moon" width="20" height="20" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                        </svg>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="main-content">
                    @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>   
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>    
    <script src="{{ asset('js/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    <script>
        $(function() {
            $("#search-input").on("keyup", function() {
                var searchQuery = $(this).val();
                if (searchQuery.length > 2) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.search') }}",
                        data: {
                            query: searchQuery
                        },
                        dataType: "json",
                        success: function(data) {
                            $("#box-content-search").html('');
                            $.each(data, function(index, item) {
                                var url = "{{ route('admin.product.edit', ['id' => 'product_id'])}}";
                                var link = url.replace('product_id', item.id);

                                $("#box-content-search").append(`
                <li>
                  <ul>
                     <li class="product-item gap14 mb-10">
                         <div class="image no-bg">
                            <img src="{{asset('uploads/products/thumbnails')}}/${item.image}" alt="${item.name}">
                          </div>
                          <div class="flex items-center justify-between gap20 flex-grow">
                          <div class="name">
                            <a href="${link}" class="body-text">${item.name}</a>
                          </div>
                       </div>
                    </li>
                    <li class="mb-10">
                       <div class="divider"></div>
                    </li>
                  </ul>
               </li>`);
                            });
                        }

                    });

                }

            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            const toggle = document.querySelector('.js-theme-toggle');
            const sunIcon = document.querySelector('.theme-icon-sun');
            const moonIcon = document.querySelector('.theme-icon-moon');

            function setTheme(theme) {
                html.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);

                if (!sunIcon || !moonIcon) {
                    return;
                }

                if (theme === 'dark') {
                    sunIcon.style.display = 'block';
                    moonIcon.style.display = 'none';
                } else {
                    sunIcon.style.display = 'none';
                    moonIcon.style.display = 'block';
                }
            }

            const savedTheme = localStorage.getItem('theme') ||
                (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            setTheme(savedTheme);

            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const current = html.getAttribute('data-theme');
                    const newTheme = current === 'dark' ? 'light' : 'dark';
                    setTheme(newTheme);
                });
            }

            // Multi-selects on product forms: click toggles the option (select/deselect) without needing shift.
            document.querySelectorAll('select.js-multi-no-range option').forEach(function(optionEl) {
                optionEl.addEventListener('mousedown', function(e) {
                    e.preventDefault();
                    optionEl.selected = !optionEl.selected;
                });
            });
        });
    </script>

    <style>
        .password-toggle-wrap {
            position: relative;
            display: block;
        }
        .password-toggle-wrap input[type="password"],
        .password-toggle-wrap input[type="text"] {
            padding-right: 2.5rem;
        }
        .password-toggle-btn {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: 0;
            padding: 0;
            line-height: 1;
            color: #6c757d;
            cursor: pointer;
            z-index: 5;
        }
        .password-toggle-btn.is-visible {
            color: #2b5e59;
        }
    </style>
    <script>
        (function() {
            function attachPasswordToggles() {
                document.querySelectorAll('input[type="password"]').forEach(function(input) {
                    if (input.dataset.passwordToggleInit === '1') {
                        return;
                    }
                    var parent = input.parentElement;
                    if (!parent) {
                        return;
                    }

                    input.dataset.passwordToggleInit = '1';
                    var wrapper = document.createElement('div');
                    wrapper.className = 'password-toggle-wrap';
                    parent.insertBefore(wrapper, input);
                    wrapper.appendChild(input);

                    var btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'password-toggle-btn';
                    btn.setAttribute('aria-label', 'Show password');

                    function setIcon(isVisible) {
                        btn.innerHTML = isVisible
                            ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 3L21 21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M10.58 10.58a2 2 0 102.83 2.83" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M16.68 16.67A10.94 10.94 0 0112 18c-5 0-9.27-3.11-11-7.5a11.8 11.8 0 012.6-4.07" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M9.88 5.09A11 11 0 0112 5c5 0 9.27 3.11 11 7.5a11.77 11.77 0 01-1.71 2.87" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>'
                            : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M1 12C2.73 7.61 7 4.5 12 4.5S21.27 7.61 23 12c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>';
                    }

                    setIcon(false);

                    btn.addEventListener('click', function() {
                        var showing = input.type === 'text';
                        input.type = showing ? 'password' : 'text';
                        btn.classList.toggle('is-visible', !showing);
                        btn.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
                        setIcon(!showing);
                    });

                    wrapper.appendChild(btn);
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', attachPasswordToggles);
            } else {
                attachPasswordToggles();
            }

            document.addEventListener('focusin', function(e) {
                if (e.target && e.target.matches('input[type="password"]') && e.target.dataset.passwordToggleInit !== '1') {
                    attachPasswordToggles();
                }
            });
        })();
    </script>
    @stack("scripts")
</body>
</html>
