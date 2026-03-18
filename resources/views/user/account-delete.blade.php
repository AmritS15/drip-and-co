@extends('layouts.app')
@section('content')
<style>
    body { min-height: 100vh; display: flex; flex-direction: column; }
    main { flex: 1; }
    .account-delete-box {
        background: var(--bs-body-bg);
        border: 1px solid var(--bs-border-color);
        border-radius: 12px;
        padding: 2rem;
        max-width: 500px;
    }
    .account-delete-box .alert-danger {
        border-left: 4px solid #dc3545;
    }
    .btn-return-cancel {
        border-color: #1e3a5f !important;
        color: #1e3a5f !important;
    }
    .btn-return-cancel:hover {
        background-color: #1e3a5f !important;
        border-color: #1e3a5f !important;
        color: #fff !important;
    }
</style>
<main class="pt-90">
    <div class="mb-4 pb-4"></div>
    <section class="my-account container">
        <h2 class="page-title">Delete Account</h2>
        <div class="row">
            <div class="col-lg-3">
                @include('user.account-nav')
            </div>
            <div class="col-lg-9">
                <div class="account-delete-box">
                    <div class="alert alert-danger mb-4" role="alert">
                        <strong>This action is not reversible.</strong> Once you delete your account, your profile, addresses, and all account data will be permanently removed. Your order history will remain in our records for administrative purposes.
                    </div>

                    <p class="mb-3">To confirm you want to delete your account, type your account name <strong>{{ Auth::user()->name }}</strong> below:</p>

                    <form method="POST" action="{{ route('user.account.destroy') }}" id="delete-account-form" data-expected-name="{{ e(Auth::user()->name) }}">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <input type="text"
                                   class="form-control @error('confirm_name') is-invalid @enderror"
                                   name="confirm_name"
                                   id="confirm_name"
                                   value="{{ old('confirm_name') }}"
                                   placeholder="Type your name to confirm"
                                   autocomplete="off"
                                   required>
                            @error('confirm_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-danger" id="btn-delete-account" disabled>Delete My Account</button>
                            <a href="{{ route('user.index') }}" class="btn btn-outline-secondary btn-return-cancel">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@push('scripts')
<script>
    (function() {
        var form = document.getElementById('delete-account-form');
        var expected = form.getAttribute('data-expected-name') || '';
        var input = document.getElementById('confirm_name');
        var btn = document.getElementById('btn-delete-account');
        input.addEventListener('input', function() {
            btn.disabled = input.value.trim() !== expected;
        });
    })();
</script>
@endpush
