@extends('layouts.main')
    <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome Sojourner</title>
    <style type="text/css" rel="stylesheet" media="all">
        /* Base ------------------------------ */
        *:not(br):not(tr):not(html) {
            font-family: Manrope, 'Helvetica Neue', Helvetica, sans-serif;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }
        body {
            width: 100% !important;
            height: 100%;
            margin: 0 ;
            line-height: 1.4;
            background-color: #F5F7F9;
            color: #839197;
            -webkit-text-size-adjust: none;
        }
        a {
            color: #117ACA;
        }
        /* Layout ------------------------------ */
        .email-wrapper {
            width: 95%;
            margin: 0 auto;
            padding: 0;
            background-color: #F5F7F9;
        }
        .email-wrapper-2 {
            width: 95%;
            margin-left: auto;
            margin-right: auto;
            margin-top: 8px;
            margin-bottom: 0;
            padding: 0;
            background-color: #F5F7F9;
        }
        .email-content {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        /* Masthead ----------------------- */
        .email-masthead {
            padding: 25px 0 4px 0;
        }
        .email-masthead_logo {
            max-width: 400px;
            border: 0;
        }
        .email-masthead_name {
            font-size: 16px;
            font-weight: bold;
            color: #839197;
            text-decoration: none;
            text-shadow: 0 1px 0 white;
        }
        .email-masthead_goto{
            padding: 10px 0;
            float: right;
        }
        .goto {
            color: #117ACA;
        }
        /* Body ------------------------------ */
        .email-body {
            width: 100%;
            margin: 0;
            padding: 0;
            border-top: 4px solid #117ACA;
            border-bottom: 1px solid #E7EAEC;
            background-color: #FFFFFF;
        }
        .email-body-2 {
            width: 100%;
            border-top: 1px solid #E7EAEC;
            border-bottom: 1px solid #E7EAEC;
            background-color: #FFFFFF;
        }
        .email-body_inner {
            width: 570px;
            margin: 0 auto;
            padding: 0;
        }
        .email-footer {
            width: 570px;
            margin: 0 auto;
            padding: 0;
            text-align: center;
        }
        .email-footer p {
            color: #839197;
        }
        .user-name{
            margin-bottom: 40px;
        }
        .body-action {
            width: 100%;
            margin: 30px auto;
            padding: 0;
            text-align: center;
        }
        .body-action-2 {
            width: 100%;
            margin: 30px auto;
            padding: 0;
            text-align: left;
        }
        .body-sub {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #E7EAEC;
        }
        .content-cell {
            padding: 30px;
        }
        .align-right {
            text-align: right;
        }
        /* Type ------------------------------ */
        h1 {
            font-style: normal;
            font-weight: 600;
            font-size: 24px;
            line-height: 30px;
            color: #111E27;
        }
        h2 {
            margin-top: 0;
            color: #292E31;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
        }
        h3 {
            margin-top: 0;
            color: #292E31;
            font-size: 14px;
            font-weight: bold;
            text-align: left;
        }
        p {
            margin-top: 0;
            color: #111E27;
            font-size: 16px;
            line-height: 1.5em;
            text-align: left;
            font-style: normal;
            font-weight: 400;
        }
        .otp-code{
            color: #117ACA;
            font-size: 18px;
            margin-bottom: 0;
        }
        p.sub {
            font-size: 12px;
        }
        p.center {
            text-align: center;
        }
        .team{
            font-weight: 500 !important;
        }
        .cheers{
            margin-bottom: 0;
        }
        /* Buttons ------------------------------ */
        .button {
            display: inline-block;
            width: 200px;
            background-color: #414EF9;
            border-radius: 3px;
            color: #ffffff;
            font-size: 15px;
            line-height: 45px;
            text-align: center;
            text-decoration: none;
            -webkit-text-size-adjust: none;
            mso-hide: all;
        }
        .button--green {
            background-color: #28DB67;
        }
        .button--red {
            background-color: #FF3665;
        }
        .button--blue {
            background-color: #117ACA;
        }
        .footer-terms {
            color: #4E637A !important;
            margin-right: 8px;
        }
        .policy {
            margin-left: 8px;
        }
        .social-media {
            margin-right: 8px;
        }
        .store{
            margin-right: 16px;
        }
        /*Media Queries ------------------------------ */
        @media only screen and (max-width: 600px) {
            .email-body_inner,
            .email-footer {
                width: 100% !important;
            }
        }
        @media only screen and (max-width: 500px) {
            .button {
                width: 100% !important;
            }
        }
    </style>
</head>
<body>
    <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table class="email-content" width="100%" cellpadding="0" cellspacing="0">
                    <!-- Logo -->
                    <tr>
                        <td class="email-masthead">
                            <a class="email-masthead_name">
                                <img src="https://s3.amazonaws.com/s3.afrinvest/optimus/logos/logoBrand.svg" >
                            </a>
                            <a class="email-masthead_goto">
                                <p class="goto">Go to your account </p>
                            </a>
                        </td>
                    </tr>
                    <!-- Email Body -->
                    <tr>
                        <td class="email-body" width="100%">
                            <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
                                <!-- Body content -->
                                <tr>
                                    <td class="content-cell">
                                        <h1 class="user-name">Hi {{$user->name}},</h1>
                                        <p>Welcome to Myride. Your ride here is always going to be smooth</p>
    
                                        <p class="verification-text">Your journey begins now! Your verification code is <br><span style="font-size:40px; text-align:center">{{$data}}</span></p>
    
                                        <!-- Action -->
    
                                        <p>For any questions, requests or comments, write to us at support@myride.ng; or use the live chat feature available in the app. </p>
    
    {{--                                    <table class="body-action-2" align="center" width="100%" cellpadding="0" cellspacing="0">--}}
    {{--                                        <tr>--}}
    {{--                                            <td>--}}
    {{--                                                <div>--}}
    {{--                                                    <a href="${link}" class="button button--blue">Fund your wallet</a>--}}
    {{--                                                </div>--}}
    {{--                                            </td>--}}
    {{--                                        </tr>--}}
    {{--                                    </table>--}}
    
                                        <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="left">
                                                    <div>
                                                        <p class="cheers">Cheers 💙,</p>
                                                        <p class="team">Enjoy your Ride</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    </html>