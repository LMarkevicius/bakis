<nav class="navbar is-danger" role="navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ route('index') }}">
      {{-- <img src="" alt="Lunch Deals Logo" width="112" height="28"> --}}
      Dienos Pietūs
    </a>
    <div class="navbar-burger burger" data-target="navbar-danger">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>

  <div id="navbar-danger" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item {{ Request::is('/') ? 'is-active' : '' }}" href="{{ route('index') }}">
        Pradžia
      </a>

      <a class="navbar-item {{ Request::is('šios-dienos-patiekalai') ? 'is-active' : '' }}" href="{{ route('todays.deals') }}">
        Šiandienos Pietūs
      </a>

      <a class="navbar-item {{ Request::is('visi-patiekalai') ? 'is-active' : '' }}" href="{{ route('all.deals') }}">
        Visi Patiekalai
      </a>

      <a class="navbar-item {{ Request::is('visi-restoranai') ? 'is-active' : '' }}" href="{{ route('restaurant.index') }}">
        Visi Restoranai
      </a>


    </div>

    <div class="navbar-end">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link {{ Request::is('apžvalga/*') ? 'is-active' : '' }}" href="#">
          Administratorius
        </a>
        <div class="navbar-dropdown is-boxed is-right">
          <a class="navbar-item {{ Request::is('apžvalga/visi-restoranai') ? 'is-active' : '' }}" href="{{ route('dashboard.index') }}">
            Apžvalga
          </a>

          <a class="navbar-item {{ Request::is('apžvalga/nustatymai') ? 'is-active' : '' }}" href="{{ route('settings.edit') }}">
            Nustatymai
          </a>

          <hr class="navbar-divider">

          <div class="navbar-item">
            <div class="field is-grouped">
              <p class="control">
                <a class="button is-primary" href="{{ route('dashboard.create') }}">
                  <span class="icon">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span>Pridėti naują restoraną</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
