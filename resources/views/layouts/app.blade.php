<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EventSphere</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#0d6efd">
  </head>
  <body>
    <a href="#main-content" class="visually-hidden-focusable">Skip to main content</a>
  <nav class="navbar navbar-expand-lg navbar-light bg-light" role="navigation" aria-label="Main navigation">
      <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">EventSphere</a>
        <div class="collapse navbar-collapse">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('messages.home') }}</a></li>


            @auth
              <!-- If logged in -->
              <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">{{ __('messages.dashboard') }}</a></li>
              @if(auth()->user()->role === 'admin')
                <li class="nav-item"><a class="nav-link" href="{{ url('/admin/users') }}">{{ __('messages.admin_panel') }}</a></li>
              @elseif(auth()->user()->role === 'organizer')
                <li class="nav-item"><a class="nav-link" href="{{ url('/organizer/events') }}">{{ __('messages.organizer_panel') }}</a></li>
              @endif
              <li class="nav-item"><a class="nav-link" href="{{ route('profile.edit') }}">{{ __('messages.profile') }}</a></li>
              <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-link nav-link" style="display:inline; cursor:pointer;">
                    {{ __('messages.logout') }}
                  </button>
                </form>
              </li>
            @else
              <!-- If not logged in -->
              <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">{{ __('messages.login') }}</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">{{ __('messages.register') }}</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                🌐
              </a>
              <ul class="dropdown-menu" aria-labelledby="langDropdown">
                <li><a class="dropdown-item" href="{{ url('lang/en') }}">English</a></li>
                <li><a class="dropdown-item" href="{{ url('lang/ur') }}">اردو</a></li>
              </ul>
            </li>
            @endauth

          </ul>
        </div>
      </div>
    </nav>
    <div class="container py-4" id="main-content" tabindex="-1">
      <button class="btn btn-sm btn-outline-dark mb-2" id="toggle-contrast" aria-pressed="false" aria-label="Toggle high contrast mode">Toggle High Contrast</button>
      @yield('content')
    </div>
    <script>
      // High contrast toggle
      document.getElementById('toggle-contrast').addEventListener('click', function() {
        document.body.classList.toggle('high-contrast');
        this.setAttribute('aria-pressed', document.body.classList.contains('high-contrast'));
      });
    </script>
    <style>
      .high-contrast, .high-contrast .navbar, .high-contrast .container {
        background: #000 !important;
        color: #fff !important;
      }
      .high-contrast a, .high-contrast .nav-link, .high-contrast .btn-link, .high-contrast .btn, .high-contrast .list-group-item {
        color: #ffd700 !important;
        background: #000 !important;
        border-color: #fff !important;
      }
      .visually-hidden-focusable {
        position: absolute;
        left: -10000px;
        top: auto;
        width: 1px;
        height: 1px;
        overflow: hidden;
      }
      .visually-hidden-focusable:focus {
        position: static;
        width: auto;
        height: auto;
      }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register('/service-worker.js');
        });
      }
    </script>
  </body>
</html>
