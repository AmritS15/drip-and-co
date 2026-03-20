@once
    @push('scripts')
        <script>
            (function() {
                function bindUkMobile11() {
                    document.querySelectorAll('input.js-uk-mobile-11').forEach(function(el) {
                        el.addEventListener('input', function() {
                            this.value = this.value.replace(/\D/g, '').slice(0, 11);
                        });
                    });
                }
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', bindUkMobile11);
                } else {
                    bindUkMobile11();
                }
            })();
        </script>
    @endpush
@endonce
