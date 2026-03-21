@extends('layouts.admin')
@section('content')

<div class="main-content-inner">
    <div class="main-content-wrap">
        <div class="flex items-center flex-wrap justify-between gap20 mb-27">
            <h3>Edit User</h3>
            <ul class="breadcrumbs flex items-center flex-wrap justify-start gap10">
                <li>
                    <a href="{{ route('admin.index') }}">
                        <div class="text-tiny">Dashboard</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li>
                    <a href="{{ route('admin.users') }}">
                        <div class="text-tiny">Users</div>
                    </a>
                </li>
                <li><i class="icon-chevron-right"></i></li>
                <li><div class="text-tiny">Edit</div></li>
            </ul>
        </div>

        <div class="wg-box">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger mb-3">{{ Session::get('error') }}</div>
            @endif
            @if(Session::has('status'))
                <div class="alert alert-success mb-3">{{ Session::get('status') }}</div>
            @endif

           <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST" class="form-new-product form-style-1 needs-validation">
                @csrf
                @method('PUT')

                <fieldset class="name">
                    <div class="body-title">Name <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="text" name="name" value="{{ old('name', $user->name) }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Mobile Number <span class="tf-color-1">*</span></div>
                    <input class="flex-grow js-uk-mobile-11" type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}"
                        required autocomplete="tel" inputmode="numeric" maxlength="11" pattern="[0-9]{11}"
                        title="Enter 11 digits">
                                    </fieldset>

                <fieldset class="name">
                    <div class="body-title">Email Address <span class="tf-color-1">*</span></div>
                    <input class="flex-grow" type="email" name="email" value="{{ old('email', $user->email) }}" required>
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Address</div>
                    <input class="flex-grow" type="text" name="address" value="{{ old('address', $user->address->address ?? '') }}" placeholder="Address">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">City</div>
                    <input class="flex-grow" type="text" name="city" value="{{ old('city', $user->address->city ?? '') }}" placeholder="City">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">County</div>
                    <input class="flex-grow" type="text" name="county" value="{{ old('county', $user->address->state ?? '') }}" placeholder="County">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Country</div>
                    <input class="flex-grow" type="text" name="country" value="{{ old('country', $user->address->country ?? '') }}" placeholder="Country">
                </fieldset>

                <fieldset class="name">
                    <div class="body-title">Postcode</div>
                    <input class="flex-grow" type="text" name="postcode" value="{{ old('postcode', $user->address->zip ?? '') }}" placeholder="Postcode">
                </fieldset>

                @if ((int) $user->id !== (int) auth()->id())
                <fieldset class="name">
                    <div class="body-title">Account type <span class="tf-color-1">*</span></div>
                    <div class="select">
                        <select name="utype" class="" required>
                            <option value="USR" {{ old('utype', $user->utype) === 'USR' ? 'selected' : '' }}>Customer</option>
                            <option value="ADM" {{ old('utype', $user->utype) === 'ADM' ? 'selected' : '' }}>Administrator</option>
                        </select>
                    </div>
                </fieldset>
                @else
                <fieldset class="name">
                    <div class="body-title">Account type</div>
                    <input class="flex-grow" type="text" value="{{ $user->utype === 'ADM' ? 'Administrator' : 'Customer' }}" disabled readonly>
                </fieldset>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <div class="my-3">
                            <h5 class="text-uppercase mb-0">Password Change</h5>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <fieldset class="name">
                            <div class="body-title pb-3">New password</div>
                            <input class="flex-grow" type="password" name="password" placeholder="New password">
                            <small class="text-muted d-block mt-1">Password must be at least 8 characters and include a number and a capital letter.</small>
                        </fieldset>
                    </div>

                    <div class="col-md-12">
                        <fieldset class="name">
                            <div class="body-title pb-3">Confirm new password</div>
                            <input class="flex-grow" type="password" name="password_confirmation" placeholder="Confirm new password">
                        </fieldset>
                    </div>

                    <div class="col-md-12">
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary tf-button w208">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

@include('partials.uk-mobile-11-script')
@endsection