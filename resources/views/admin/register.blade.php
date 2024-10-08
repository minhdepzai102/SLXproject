<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.header')
</head>

<body>
    @include('admin.error')
    <div class="login-light"></div>
    <div class="login-box" style="height: 556px;">
        <form id="registerForm" action="register/store" method="POST" autocomplete="off">
            @csrf
            <input type="checkbox" class="input-check" id="input-check">
            <label for="input-check" class="toggle">
                <span class="text off">off</span>
                <span class="text on">on</span>
            </label>
            <div class="light"></div>
            <h2>Register</h2>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="person"></ion-icon>
                </span>
                <input type="text" name="name" required autocomplete="new-name"> <!-- Use 'new-name' -->
                <label>Name</label>
                <div class="input-line"></div>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="mail"></ion-icon>
                </span>
                <input type="email" name="email" required autocomplete="new-email"> <!-- Use 'new-email' -->
                <label>Email</label>
                <div class="input-line"></div>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" name="password" required autocomplete="new-password"> <!-- Use 'new-password' -->
                <label>Password</label>
                <div class="input-line"></div>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" name="password_confirmation" required autocomplete="new-password">
                <!-- Use 'new-password' -->
                <label>Confirm Password</label>
                <div class="input-line"></div>
            </div>

            <button type="submit">Register</button>
            <div class="register-link">
                <p>Already have an account? <a href="login">Login</a></p>
            </div>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- JavaScript to ensure autocomplete is off -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const inputs = document.querySelectorAll("#registerForm input");
            inputs.forEach(input => {
                input.setAttribute("autocomplete", "off"); // Disable autocomplete
            });
        });
    </script>
</body>
@include('admin.footer')
</html>