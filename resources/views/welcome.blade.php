<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
                margin-left: 30px;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                vertical-align: middle;
            }




            .title {
                font-size: 96px;
            }
        </style>

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

    </head>
    <body>
        <div class="container">
            <div class="content">

                @if (!Auth::check())
                    <button onclick="lock.show();">Login</button>
                @else

                    <p>{{ $client->clientName }}</p>
                    <ul>
                    @foreach ($client->clientFiles as $file)
                        <li>{{ $file->fileName }}</li>
                    @endforeach
                    </ul>

                @endif
            </div>
        </div>
    </body>
</html>
