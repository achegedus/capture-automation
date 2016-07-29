<html>
<body>
<h1>Laravel Auth0 Quickstart</h1>

<script src="https://cdn.auth0.com/js/lock/10.0/lock.min.js"></script>
<script type="text/javascript">
    var lock = new Auth0Lock('ZPNBmSe2cPHErqO7Wx6aZkqo3eLwOwZT', 'energycap.auth0.com', {
        rememberLastLogin: false,
        allowForgotPassword: false,
        allowSignUp: false,
        auth: {
            redirectUrl: 'http://localhost:8000/auth0/callback',
            responseType: 'code',
            params: {
                scope: 'openid email' // Learn about scopes: https://auth0.com/docs/scopes
            }
        }
    });
</script>

@if (!Auth::check())
<button onclick="lock.show();">Login</button>
@endif
</body>
</html>
