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
    <title>Login - Pos admin template</title>

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
                            <h3>Sign In</h3>
                            <h4>
                                Access the Dreamspos panel using your email and passcode.
                            </h4>
                        </div>
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-login">
                                <label>Username</label>
                                <div class="form-addons">
                                    <input type="text" name="username" class="form-control" />
                                    <img src="assets/img/icons/mail.svg" alt="img" />
                                </div>
                            </div>
                            <div class="form-login">
                                <label>Password</label>
                                <div class="pass-group">
                                    <input type="password" name="password" class="pass-input" />
                                    <span class="fas toggle-password fa-eye-slash"></span>
                                </div>
                            </div>
                            <div class="form-login">
                                <button type="submit" class="btn btn-login">Sign In</button>
                            </div>
                        </form>
                        <div class="signinform text-center">
                            <h4>
                                New on our platform?<a href="{{ route('register') }}" class="hover-a">
                                    Create an account</a>
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

    <div class="customizer-links" id="setdata">
        <ul class="sticky-sidebar">
            <li class="sidebar-icons">
                <a href="#" class="navigation-add" data-bs-toggle="tooltip" data-bs-placement="left"
                    data-bs-original-title="Theme">
                    <i data-feather="settings" class="feather-five"></i>
                </a>
            </li>
        </ul>
    </div>

    <script
      src="assets/js/jquery-3.7.1.min.js"
      type="dd3d52f84aa70e1a5fe138c1-text/javascript"
    ></script>

    <script
      src="assets/js/feather.min.js"
      type="dd3d52f84aa70e1a5fe138c1-text/javascript"
    ></script>

    <script
      src="assets/js/bootstrap.bundle.min.js"
      type="dd3d52f84aa70e1a5fe138c1-text/javascript"
    ></script>

    <script
      src="assets/js/theme-script.js"
      type="dd3d52f84aa70e1a5fe138c1-text/javascript"
    ></script>
    <script
      src="assets/js/script.js"
      type="dd3d52f84aa70e1a5fe138c1-text/javascript"
    ></script>
    <script src="assets/js/rocket-loader.min.js" data-cf-settings="dd3d52f84aa70e1a5fe138c1-|49" defer></script>
</body>

</html>
