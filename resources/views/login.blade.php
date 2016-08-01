@extends('layouts.main')



@section('content')

    <div id="root" style="width: 320px; margin: 40px auto; padding: 10px; box-sizing: border-box;">
    </div>

    <script src="https://cdn.auth0.com/js/lock/10.0/lock.min.js"></script>
    <script type="text/javascript">
        var lock = new Auth0Lock('ZPNBmSe2cPHErqO7Wx6aZkqo3eLwOwZT', 'energycap.auth0.com', {
            container: 'root',
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
        lock.show();
    </script>

@endsection
