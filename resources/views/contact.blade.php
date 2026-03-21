@extends('layouts.app')
@section('content')
<style>
.text-danger {
    color: #e72010 !important;
}
.site-rating__star-btn .site-rating__star { color: #ccc; }
.site-rating__star-btn .site-rating__star[fill="currentColor"] { color: #ffc107; }
.site-rating__star-btn:hover .site-rating__star { color: #ffc107; }
.site-rating__stars--display .site-rating__fill-wrapper { width: 90px; height: 18px; }
.site-rating__stars-bg, .site-rating__stars-fill { display: flex; flex-direction: row; gap: 0; width: 90px; height: 18px; line-height: 0; }
.site-rating__stars-bg svg, .site-rating__stars-fill svg { width: 18px; height: 18px; flex-shrink: 0; display: block; }
.site-rating__stars-bg { color: #ccc; }
.site-rating__stars-fill { color: #ffc107; }
html[data-theme="dark"] main.page-contact {
    color: #f9fafb !important;
}
html[data-theme="dark"] main.page-contact .contact-us,
html[data-theme="dark"] main.page-contact .contact-us p,
html[data-theme="dark"] main.page-contact .contact-us strong,
html[data-theme="dark"] main.page-contact .contact-us h2,
html[data-theme="dark"] main.page-contact .contact-us h3,
html[data-theme="dark"] main.page-contact .contact-us h4,
html[data-theme="dark"] main.page-contact .contact-us h5,
html[data-theme="dark"] main.page-contact .contact-us label,
html[data-theme="dark"] main.page-contact .contact-us .fw-medium,
html[data-theme="dark"] main.page-contact .contact-us .site-rating,
html[data-theme="dark"] main.page-contact .contact-us #site-rating-text,
html[data-theme="dark"] main.page-contact .contact-us .small {
    color: #f9fafb !important;
}
html[data-theme="dark"] main.page-contact .contact-us .text-secondary {
    color: #cbd5e1 !important;
}
html[data-theme="dark"] main.page-contact .contact-us .contact-us__form {
    background-color: #383B3C !important;
}
html[data-theme="dark"] main.page-contact .contact-us .form-control,
html[data-theme="dark"] main.page-contact .contact-us textarea.form-control {
    color: #f9fafb !important;
    -webkit-text-fill-color: #f9fafb !important;
    background-color: #383B3C !important;
    border-color: #ffffff !important;
}
html[data-theme="dark"] main.page-contact .contact-us .form-control::placeholder,
html[data-theme="dark"] main.page-contact .contact-us textarea.form-control::placeholder {
    color: rgba(255, 255, 255, 0.55) !important;
}
html[data-theme="dark"] main.page-contact .contact-us .alert-success {
    color: #dcfce7 !important;
    background-color: #14532d !important;
    border-color: #166534 !important;
}
html[data-theme="dark"] main.page-contact .contact-us .border-top {
    border-color: #4b5563 !important;
}
</style>
<main class="pt-90 page-contact">
    <div class="mb-4 pb-4"></div>
    <section class="contact-us container">
      <div class="mw-930">
        <h2 class="page-title">CONTACT US</h2>
        <div class="mb-4">
          <p class="mb-1"><strong>Address:</strong> {{ config('store.contact.address') }}</p>
          <p class="mb-1"><strong>Email:</strong> {{ config('store.contact.email') }}</p>
          <p class="mb-0"><strong>Phone:</strong> {{ config('store.contact.phone') }}</p>
        </div>
      </div>
    </section>

    <div class="mb-1 pb-1"></div>

    <section class="contact-us container">
      <div class="mw-930">
        <div class="contact-us__form">
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
          <form name="contact-us-form" class="needs-validation" novalidate="" action="{{route('home.contact.store')}}" method="POST">
            @csrf
            <h3 class="mb-3">Get In Touch</h3>
            <div class="my-4">
              <input type="text" class="form-control" id="contact_us_name" name="name" placeholder="Name *" value="{{old('name')}}" required aria-label="Name">
             @error('name') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <input type="text" class="form-control" id="contact_us_phone" name="phone" placeholder="Phone *" value="{{old('phone')}}" required aria-label="Phone">
              @error('phone') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <input type="email" class="form-control" id="contact_us_email" name="email" placeholder="Email address *" value="{{old('email')}}" required aria-label="Email address">
              @error('email') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <textarea class="form-control form-control_gray" id="contact_us_comment" name="comment" placeholder="Your Message" cols="30"
                rows="8" required aria-label="Your message">{{old('comment')}}</textarea>
              @error('comment') <span class="text-danger">{{$message}}</span> @enderror
            </div>
            <div class="my-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>

          <div class="site-rating mt-5 pt-5 border-top">
            <h3 class="mb-3">Rate your site experience</h3>
            <div class="site-rating__user mb-4">
              <div class="site-rating__stars site-rating__stars--input d-flex gap-1 align-items-center" role="group" aria-label="Rate 1 to 5 stars">
                @for ($i = 1; $i <= 5; $i++)
                  <button type="button" class="site-rating__star-btn border-0 bg-transparent p-0" data-rating="{{ $i }}" aria-label="{{ $i }} star{{ $i !== 1 ? 's' : '' }}">
                    <svg class="site-rating__star" width="28" height="28" viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" fill="{{ ($userRating !== null && $i <= $userRating) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="0.5">
                      <use href="#icon_star" />
                    </svg>
                  </button>
                @endfor
              </div>
              <p class="small text-secondary mt-1 mb-0" id="site-rating-message"></p>
            </div>
            <div class="site-rating__overall">
              <p class="mb-1 fw-medium">Overall rating</p>
              <div class="site-rating__stars site-rating__stars--display d-flex align-items-center gap-2">
                <div class="site-rating__fill-wrapper position-relative">
                  <span class="site-rating__stars-bg position-absolute top-0 start-0">
                    @for ($i = 1; $i <= 5; $i++)
                      <svg viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><use href="#icon_star" /></svg>
                    @endfor
                  </span>
                  <span class="site-rating__stars-fill position-absolute top-0 start-0 overflow-hidden" style="width: {{ $siteRatingAvg !== null ? min(100, ($siteRatingAvg / 5) * 100) : 0 }}%;">
                    @for ($i = 1; $i <= 5; $i++)
                      <svg viewBox="0 0 9 9" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><use href="#icon_star" /></svg>
                    @endfor
                  </span>
                </div>
                <span id="site-rating-text">
                  @if ($siteRatingAvg !== null && $siteRatingCount > 0)
                    {{ number_format($siteRatingAvg, 1) }} (from {{ $siteRatingCount }} {{ $siteRatingCount === 1 ? 'rating' : 'ratings' }})
                  @else
                    No ratings yet
                  @endif
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <script>
    (function() {
      var form = document.querySelector('form[name="contact-us-form"]');
      if (!form) return;
      var container = form.closest('.contact-us__form');
      var starBtns = container ? container.querySelectorAll('.site-rating__star-btn') : [];
      var messageEl = document.getElementById('site-rating-message');
      var textEl = document.getElementById('site-rating-text');
      var fillEl = container ? container.querySelector('.site-rating__stars-fill') : null;
      var url = '{{ route("home.site_rating.store") }}';
      var csrf = '{{ csrf_token() }}';

      function setHoverStars(n) {
        starBtns.forEach(function(btn, i) {
          var star = btn.querySelector('.site-rating__star');
          if (star) star.setAttribute('fill', (i + 1) <= n ? 'currentColor' : 'none');
        });
      }

      function setSelectedStars(n) {
        var r = n || 0;
        starBtns.forEach(function(btn, i) {
          var star = btn.querySelector('.site-rating__star');
          if (star) star.setAttribute('fill', (i + 1) <= r ? 'currentColor' : 'none');
        });
      }

      var currentRating = {{ $userRating ?? 'null' }};
      setSelectedStars(currentRating);

      starBtns.forEach(function(btn) {
        var r = parseInt(btn.getAttribute('data-rating'), 10);
        btn.addEventListener('click', function() {
          if (messageEl) messageEl.textContent = 'Saving…';
          var body = new FormData();
          body.append('rating', r);
          body.append('_token', csrf);
          fetch(url, { method: 'POST', body: body, headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
            .then(function(res) { return res.json(); })
            .then(function(data) {
              if (data.ok) {
                currentRating = r;
                setSelectedStars(r);
                if (messageEl) messageEl.textContent = 'Thanks for your rating!';
                if (textEl) {
                  textEl.textContent = (data.average != null ? data.average.toFixed(1) : '–') + ' (from ' + data.count + ' ' + (data.count === 1 ? 'rating' : 'ratings') + ')';
                }
                if (fillEl) fillEl.style.width = (data.average != null ? Math.min(100, (data.average / 5) * 100) : 0) + '%';
              }
            })
            .catch(function() {
              if (messageEl) messageEl.textContent = 'Could not save rating. Try again.';
            });
        });
        btn.addEventListener('mouseenter', function() { setHoverStars(r); });
        btn.addEventListener('mouseleave', function() { setSelectedStars(currentRating); });
      });
    })();
  </script>
@endsection