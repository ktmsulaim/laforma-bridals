<ul class="customer-account-navigation">
    <li>
        <a href="{{ route('customer.dashboard') }}" class="{{ Route::currentRouteName() === 'customer.dashboard' ? 'active' : '' }}">
            <span class="mdi mdi-home-outline"></span> Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('customer.address.index') }}" class="{{ Route::currentRouteName() === 'customer.address.index' ? 'active' : '' }}">
            <span class="mdi mdi-map-marker-outline"></span> Addresses
        </a>
    </li>
    <li>
        <a href="{{ route('customer.account') }}" class="{{ Route::currentRouteName() === 'customer.account' ? 'active' : '' }}">
            <span class="ti-user"></span> Account
        </a>
    </li>
    <li>
        <a href="{{ route('customer.orders') }}" class="{{ Route::currentRouteName() === 'customer.orders' ? 'active' : '' }}">
            <span class="ti-package"></span> Orders
        </a>
    </li>
    <li>
        <a href="{{ route('customer.bookings') }}" class="{{ Route::currentRouteName() === 'customer.bookings' ? 'active' : '' }}">
            <span class="mdi mdi-calendar-check"></span> Bookings
        </a>
    </li>
    <li>
        <a href="{{ route('customer.wishlist') }}" class="{{ Route::currentRouteName() === 'customer.wishlist' ? 'active' : '' }}">
            <span class="mdi mdi-heart-circle-outline"></span> Wishlist
        </a>
    </li>
    <li>
        <a href="{{ route('customer.reviews') }}" class="{{ Route::currentRouteName() === 'customer.reviews' ? 'active' : '' }}">
            <span class="ti-comments"></span> Reviews
        </a>
    </li>
</ul>
