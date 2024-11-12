<nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
    <div class="container text-light">
        <div class="w-100 d-flex justify-content-between">
            <div>
                <i class="fa fa-envelope mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:{{ $shopDetails->email ?? 'info@company.com' }}">
                    {{ $shopDetails->email ?? 'info@company.com' }}
                </a>
                <i class="fa fa-phone mx-2"></i>
                <a class="navbar-sm-brand text-light text-decoration-none" href="tel:{{ $shopDetails->phone ?? '010-020-0340' }}">
                    {{ $shopDetails->phone ?? '010-020-0340' }}
                </a>
            </div>
            <div>
                <a class="text-light" href="{{ $shopDetails->facebook ?? '#' }}" target="_blank"><i class="fab fa-facebook-f fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->instagram ?? '#' }}" target="_blank"><i class="fab fa-instagram fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->twitter ?? '#' }}" target="_blank"><i class="fab fa-twitter fa-sm fa-fw me-2"></i></a>
                <a class="text-light" href="{{ $shopDetails->linkedin ?? '#' }}" target="_blank"><i class="fab fa-linkedin fa-sm fa-fw"></i></a>
            </div>
        </div>
    </div>
</nav>