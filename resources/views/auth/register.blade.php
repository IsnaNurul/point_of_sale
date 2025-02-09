<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <meta name="description" content="POS - Bootstrap Admin Template" />
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects" />
    <meta name="author" content="Dreamguys - Bootstrap Admin Template" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Register - Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png" />

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css" />
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body class="account-page">

    <div class="main-wrapper">
        <div class="account-content">
            <div class="login-wrapper">
                <div class="login-content">
                    <div class="login-userset">
                        <div class="login-logo logo-normal">
                            <img src="assets/img/logo.png" alt="img" />
                        </div>
                        <a href="index.html" class="login-logo logo-white">
                            <img src="assets/img/logo-white.png" alt />
                        </a>
                        <div class="login-userheading">
                            <h3>Create Account</h3>
                            <h4>
                                Access the Dreamspos panel using your email and passcode.
                            </h4>
                        </div>
                        <form action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="form-login">
                                <label>Name</label>
                                <div class="form-addons">
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name') }}" />
                                    <img src="assets/img/icons/user-icon.svg" alt="img" />
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-login">
                                <label>Username</label>
                                <div class="form-addons">
                                    <input type="text" name="username" class="form-control"
                                        value="{{ old('username') }}" />
                                    <img src="assets/img/icons/mail.svg" alt="img" />
                                </div>
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="pass-input" />
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-login">
                                <label>Confirm Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password_confirmation" class="pass-input" />
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Sign Up</button>
                            </div>
                        </form>

                        <div class="signinform text-center">
                            <h4>
                                Have an Account?<a href="{{ route('form-login') }}" class="hover-a">
                                    Sign In</a>
                            </h4>
                        </div>
                    </div>
                </div>
                <div class="login-img">
                    <img src="assets/img/authentication/login02.png" alt="img" />
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/theme-script.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
