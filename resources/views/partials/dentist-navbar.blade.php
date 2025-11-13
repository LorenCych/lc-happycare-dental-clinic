<!-- Custom Navbar Styles -->
<link rel="stylesheet" href="/assets/css/registrant-navbar.css">

<nav class="navbar navbar-expand-md sticky-top custom-navbar bg-body py-3">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Left side: Menu button (hidden since we have fixed sidebar) -->
      <div class="d-flex align-items-center">
        <!-- Spacer for fixed sidebar -->
      </div>

      <!-- Center: Brand -->
      <div class="position-absolute start-50 translate-middle-x">
        <a class="navbar-brand d-flex align-items-center m-0" href="{{ route('dentist.dashboard') }}">
          <span class="bs-icon-sm bs-icon-rounded bs-icon-primary d-flex justify-content-center align-items-center me-2 bs-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-bezier">
              <path fill-rule="evenodd"
                d="M0 10.5A1.5 1.5 0 0 1 1.5 9h1A1.5 1.5 0 0 1 4 10.5v1A1.5 1.5 0 0 1 2.5 13h-1A1.5 1.5 0 0 1 0 11.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm10.5.5A1.5 1.5 0 0 1 13.5 9h1a1.5 1.5 0 0 1 1.5 1.5v1a1.5 1.5 0 0 1-1.5 1.5h-1a1.5 1.5 0 0 1-1.5-1.5zm1.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM6 4.5A1.5 1.5 0 0 1 7.5 3h1A1.5 1.5 0 0 1 10 4.5v1A1.5 1.5 0 0 1 8.5 7h-1A1.5 1.5 0 0 1 6 5.5zM7.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z">
              </path>
              <path
                d="M6 4.5H1.866a1 1 0 1 0 0 1h2.668A6.517 6.517 0 0 0 1.814 9H2.5c.123 0 .244.015.358.043a5.517 5.517 0 0 1 3.185-3.185A1.503 1.503 0 0 1 6 5.5zm3.957 1.358A1.5 1.5 0 0 0 10 5.5v-1h4.134a1 1 0 1 1 0 1h-2.668a6.517 6.517 0 0 1 2.72 3.5H13.5c-.123 0-.243.015-.358.043a5.517 5.517 0 0 0-3.185-3.185z">
              </path>
            </svg>
          </span>
          <span><strong>LC HAPPY CARE</strong></span>
        </a>
      </div>

      <!-- Right side: Welcome message and user info -->
      <div class="d-flex align-items-center">
        @php
          $dentist = session('dentist') ?? \App\Models\Admin::find(session('admin_id'));
        @endphp
        
        @if($dentist)
          <span class="text-muted me-3 d-none d-md-inline">Welcome, Dr. {{ $dentist->first_name }}</span>
          <form action="{{ route('dentist.logout') }}" method="post" class="d-flex align-items-center">
            @csrf
            <button type="submit" role="button" class="btn btn-primary">Sign Out</button>
          </form>
        @endif
      </div>
    </div>
</nav>