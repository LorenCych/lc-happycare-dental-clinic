<style>
  /* Adjust for fixed sidebar */
  body {
    padding-left: 4rem !important;
  }
  
  /* Reset padding for sections that contain the sidebar */
  section.d-flex {
    padding-left: 0 !important;
    margin-left: -4rem !important;
  }
  
  /* Ensure main content takes full available width */
  section.d-flex > #main-content {
    margin-left: 4rem !important;
    width: calc(100% - 4rem) !important;
    flex-grow: 1 !important;
  }
  
  /* Alternative: target all main content areas */
  #main-content {
    margin-left: 4rem !important;
  }
</style>

<div class="bg-body bg-gradient shadow position-fixed top-0 start-0 d-flex z-3 h-100 flex-column flex-shrink-0"
      id="sidebar" style="width: 4rem; transition: width 0.3s;"><a
        class="text-center link-body-emphasis d-block p-3 text-decoration-none border-bottom" href="/" title=""
        data-bs-toggle="tooltip" data-bs-placement="right" data-bs-original-title="Icon-only"><svg
          xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
          class="bi bi-h-square-fill" style="font-size: 25px;">
          <path
            d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm9 4.002V12H9.67V8.455H6.33V12H5V4.002h1.33v3.322h3.34V4.002z">
          </path>
        </svg><span class="visually-hidden">Icon-only</span></a>
      <ul class="nav nav-pills flex-column text-center mb-auto">
        @php
          $admin = session('dentist') ?? \App\Models\Admin::find(session('admin_id'));
        @endphp
        
        <li class="nav-item"><!-- Start: view --><a class="nav-link link-primary rounded-0 py-3 border-bottom"
            data-bs-toggle="tooltip" data-bss-tooltip="" href="{{ route('dentist.dashboard') }}" aria-current="page"
            title="Dashboard"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor"
              viewBox="0 0 16 16" class="bi bi-grid-1x2-fill fs-4">
              <path
                d="M0 1a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm9 0a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1zm0 9a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1z">
              </path>
            </svg></a><!-- End: view --></li>
        <li class="nav-item">
            @if ($admin && $admin->role_level != 3)
            <a class="nav-link link-primary rounded-0 py-3 border-bottom" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.appointments.assigned') }}" title="My Appointments"><svg
              xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
              class="bi bi-calendar-week-fill fs-4">
              <path
                d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5">
              </path>
            </svg></a>
            @endif
            
            @if ($admin && $admin->role_level != 3)
            <a class="nav-link link-primary rounded-0 py-3 border-bottom" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.appointments.previous') }}" title="View History"><svg
              xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
              class="bi bi-clock-fill fs-4" title="Self-Assign Appointments">
              <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z">
              </path>
            </svg></a>
            @endif
            
            <a class="nav-link link-primary rounded-0 py-3 border-bottom" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.appointments.unassigned') }}" 
            title="{{ ($admin && $admin->role_level != 3) ? 'Accept Appointments' : 'View Unassigned Appointments' }}"><svg
              xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
              class="bi bi-pen-fill fs-4" title="{{ ($admin && $admin->role_level != 3) ? 'Accept Appointments' : 'View Unassigned Appointments' }}">
              <path
                d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001">
              </path>
            </svg></a>
            
            @if ($admin && $admin->role_level != 3)
            <a class="nav-link link-primary rounded-0 py-3 border-bottom" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.patients.records') }}" title="Patient Records"><svg
              xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
              class="bi bi-person-lines-fill fs-4">
              <path
                d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z">
              </path>
            </svg></a>
            @endif
            </li>
        <li class="nav-item"><a class="nav-link py-3 border-bottom rounded-0" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.account.manage') }}" title="Manage Profile"><svg
              xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16"
              class="bi bi-person-fill-gear fs-4 link-primary">
              <path
                d="M11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0m-9 8c0 1 1 1 1 1h5.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.544-3.393C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4m9.886-3.54c.18-.613 1.048-.613 1.229 0l.043.148a.64.64 0 0 0 .921.382l.136-.074c.561-.306 1.175.308.87.869l-.075.136a.64.64 0 0 0 .382.92l.149.045c.612.18.612 1.048 0 1.229l-.15.043a.64.64 0 0 0-.38.921l.074.136c.305.561-.309 1.175-.87.87l-.136-.075a.64.64 0 0 0-.92.382l-.045.149c-.18.612-1.048.612-1.229 0l-.043-.15a.64.64 0 0 0-.921-.38l-.136.074c-.561.305-1.175-.309-.87-.87l.075-.136a.64.64 0 0 0-.382-.92l-.148-.045c-.613-.18-.613-1.048 0-1.229l.148-.043a.64.64 0 0 0 .382-.921l-.074-.136c-.306-.561.308-1.175.869-.87l.136.075a.64.64 0 0 0 .92-.382l.045-.148ZM14 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0">
              </path>
            </svg></a></li>
        @if ($admin && $admin->role_level == 1)
        <li class="nav-item"><a class="nav-link link-primary rounded-0 py-3 border-bottom" data-bs-toggle="tooltip"
            data-bss-tooltip="" href="{{ route('dentist.admin.create') }}" title="Create Dentist Accounts"><svg xmlns="http://www.w3.org/2000/svg"
              width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-person-workspace fs-4">
              <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"></path>
              <path
                d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z">
              </path>
            </svg></a></li>
        @endif
      </ul>
      <div class="dropdown p-3 border-top">
        @php
          $dentist = session('dentist') ?? \App\Models\Admin::find(session('admin_id'));
          $initial = $dentist ? strtoupper(substr($dentist->first_name, 0, 1)) : 'D';
        @endphp
        <a class="dropdown-toggle link-body-emphasis d-flex align-items-center justify-content-center text-decoration-none"
           aria-expanded="false" data-bs-toggle="dropdown" role="button">
          <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
               style="width: 32px; height: 32px; min-width: 32px; min-height: 32px; font-size: 1rem; flex-shrink: 0;">
            {{ $initial }}
          </div>
        </a>
        <div class="dropdown-menu shadow position-absolute z-3" data-popper-placement="top-start">
              @if ($admin && $admin->role_level != 3)
          <a class="dropdown-item" href="{{ route('dentist.appointments.assigned') }}">View My Appointments</a>
          <a class="dropdown-item" href="{{ route('dentist.patients.records') }}">Patient Records</a>
            @endif
            <a class="dropdown-item" href="{{ route('dentist.account.manage') }}">Manage Profile</a>
          <div class="dropdown-divider"></div>
          <form id="logout-form" action="{{ route('dentist.logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
          <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
        </div>
      </div>
    </div><!-- End: Sidebar With Icons --><!-- Start: view -->