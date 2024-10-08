@include('admin.header')

<body>
@include('admin.error');
    <div class="login-light"></div>
    <div class="login-box">
        <form action="login/store" method="POST" autocomplete="off">
            @csrf
            <input type="checkbox" class="input-check" id="input-check">
            <label for="input-check" class="toggle">
                <span class="text off">off</span>
                <span class="text on">on</span>
            </label>
            <div class="light"></div>

            <h2>Login</h2>
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="mail"></ion-icon>
                </span>
                <input type="email" name="email" required autocomplete="off"> <!-- Added name attribute -->
                <label>Email</label>
                <div class="input-line"></div>
            </div>
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" name="password" required autocomplete="new-password">
                <label>Password</label>
                <div class="input-line"></div>
            </div>
            <div class="remember-forgot">
                <label><input type="checkbox" name="remember"> Remember me</label>
                <a href="#">Forgot Password?</a>
            </div>
            <button type="submit">Login</button>
            <div class="register-link">
                <p>Don't have an account? <a href="register">Register</a></p>
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
@include('admin.footer')
