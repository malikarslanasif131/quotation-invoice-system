<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Quotation & Invoice</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('clients.index') }}">Clients</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('items.index') }}">Items</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('quotations.index') }}">Quotations</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('invoices.index') }}">Invoices</a></li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <span class="nav-link">Hi, {{ auth()->user()->name }}</span>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-link nav-link" type="submit">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>