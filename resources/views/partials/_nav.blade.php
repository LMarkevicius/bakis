<nav class="navbar is-danger" role="navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ route('index') }}">
      {{-- <img src="" alt="Lunch Deals Logo" width="112" height="28"> --}}
      Lunch Deals
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
        Home
      </a>

      <a class="navbar-item {{ Request::is('todays-deals') ? 'is-active' : '' }}" href="{{ route('todays.deals') }}">
        Today's Deals
      </a>

      <a class="navbar-item {{ Request::is('all-deals') ? 'is-active' : '' }}" href="{{ route('all.deals') }}">
        All Deals
      </a>

      <a class="navbar-item {{ Request::is('all_restaurants') ? 'is-active' : '' }}" href="{{ route('restaurant.index') }}">
        All Restaurants
      </a>


    </div>

    <div class="navbar-end">
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link {{ Request::is('all_restaurants') ? 'is-active' : '' }}" href="#">
          Admin
        </a>
        <div class="navbar-dropdown is-boxed is-right">
          <a class="navbar-item {{ Request::is('dashboard/all-restaurants') ? 'is-active' : '' }}" href="{{ route('dashboard.index') }}">
            Dashboard
          </a>

          <hr class="navbar-divider">

          <div class="navbar-item">
            <div class="field is-grouped">
              <p class="control">
                <a class="button is-primary" href="{{ route('dashboard.create') }}">
                  <span class="icon">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span>Add New Restaurant</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</nav>
