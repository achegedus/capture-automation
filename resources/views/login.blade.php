@extends('layouts.main')



@section('content')

    <div class="row">
        <div class="col-md-8">
            <h1>Welcome to EnergyCAP Bill CAPture!</h1>
            <p>At EnergyCAP, we understand the frustrating data entry tasks associated with utility bill tracking.
                Let us set you free from the challenging burden of utility bill data entry with Bill CAPture, a
                sophisticated service that converts your PDF, XLS, TXT, CSV, and/or EDI file formats, and even your
                paper bills, to a format that can be electronically imported into your EnergyCAP database.</p>
            <p>Here’s how it works:</p>

            <img src="/images/billcapture_process.png" class="center-block" alt="">

            <a href="http://billcapture.energycap.com/docs/pages/viewpage.action?pageId=819307" class="button btn btn-primary">Learn more</a>
        </div>

        <div id="root" class="col-md-4" >
        </div>
    </div>

    <script src="https://cdn.auth0.com/js/lock/10.0/lock.min.js"></script>
    <script type="text/javascript">
        var lock = new Auth0Lock('ZPNBmSe2cPHErqO7Wx6aZkqo3eLwOwZT', 'energycap.auth0.com', {
            container: 'root',
            rememberLastLogin: false,
            allowForgotPassword: false,
            allowSignUp: false,
            theme: {
                logo: '',
                primaryColor: '#C1CD21'
            },
            languageDictionary: {
                emailInputPlaceholder: "something@youremail.com",
                title: "EnergyCAP CAPture Services Login"
            },
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
