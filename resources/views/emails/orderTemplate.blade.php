<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Email</title>
  </head>
  <body>
    <table
        width="600"
        style="
            font-family: Arial, Helvetica, sans-serif;
            font-size: 0.875rem;
            color: rgb(51, 51, 51);
        "
        >
        <tr>
            <td>
            <div
                style="
                background-color: #295eac;
                height: 8px;
                width: 30%;
                float: left;
                "
            ></div>
            <div
                style="
                background-color: #63a7ea;
                height: 8px;
                width: 70%;
                float: left;
                "
            ></div>
            </td>
        </tr>
        <tr>
            <td style="padding: 32px 48px 0 48px">
            <img src="{{config('app.url')}}/images/logo.svg" alt="Quick Track" width="120" />
            </td>
        </tr>
        <tr>
            <td style="padding: 0 48px">
            <div style="margin-top: 2rem; font-size: 1rem">Hi,</div>
            </td>
        </tr>
        <tr>
            <td style="padding: 0 48px">
                <p style="font-size: 16px; font-weight: 600; margin: 0.5rem 0">
                    {{$name}}!
                </p>

                <p>
                    {{$content}}
                </p>
            </td>
        </tr>
        @if (strtolower($process) == 'active')
            <tr>
                <td style="padding: 0 48px">
                <table
                    style="
                    font-size: 0.75rem;
                    margin-top: 0.5rem;
                    padding: 1rem;
                    width: 100%;
                    background-color: rgb(246, 246, 246);
                    "
                >
                    <tr>
                    <td colspan="2" style="vertical-align: top; width: 50%">
                        <table>
                        <tr>
                            <td>
                            <div
                                style="
                                font-size: 0.875rem;
                                font-weight: 600;
                                margin-bottom: 1rem;
                                color: #295eac;
                                "
                            >
                                Invoice Details
                            </div>
                            </td>
                        </tr>
                        </table>
                    </td>
                    </tr>
                    <tr>
                    <td style="vertical-align: top; width: 50%" colspan="2">
                        <p style="margin: 0 0 4px 0">Reservation ID</p>
                        <span
                        style="
                            font-weight: 600;
                            padding-bottom: 1.5rem;
                            display: block;
                        "
                        >
                        {{$order->reservation_code}}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td style="vertical-align: top; width: 50%" colspan="2">
                        <p style="margin: 0 0 4px 0">Vehicle</p>
                        <span
                        style="
                            font-weight: 600;
                            padding-bottom: 1.5rem;
                            display: block;
                        "
                        >
                        {{$order->vehicles->model}}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td style="vertical-align: top; width: 50%" colspan="2">
                        <p style="margin: 0 0 4px 0">Reservation Period</p>
                        <span
                        style="
                            font-weight: 600;
                            padding-bottom: 1.5rem;
                            display: block;
                        "
                        >
                            {{date('H:i A jS M Y', strtotime($order->start_dt)) .' - '. date('H:i A jS M Y', strtotime($order->end_dt))}}
                        </span>
                    </td>
                    </tr>
                    <tr>
                    <td style="vertical-align: top; width: 50%">
                        <p style="margin: 0 0 4px 0">Payment Method</p>
                        <span
                        style="
                            font-weight: 600;
                            padding-bottom: 1.5rem;
                            display: block;
                        "
                        >
                        Paypal
                        </span>
                    </td>
                    <td style="vertical-align: top; width: 50%">
                        <p style="margin: 0 0 4px 0">Payment Amount</p>
                        <span
                        style="
                            font-weight: 600;
                            padding-bottom: 1.5rem;
                            display: block;
                        "
                        >
                        ${{number_format($order->amount, 2)}}
                        </span>
                    </td>
                    </tr>
                </table>
                </td>
            </tr>
        @endif
        <tr>
            <td style="padding: 1rem 48px 1.5rem 48px">
            For additional help or information, email us at
            <a href="mailto:support@everestrental.com" style="color: #63a7ea">support@everestrental.com</a>
            </td>
        </tr>
        <tr>
            <td style="background-color: #295eac; padding: 1rem 0">
            <table
                style="
                font-size: 0.75rem;
                color: rgb(255, 255, 255);
                width: 100%;
                text-align: center;
                "
            >
                <tr>
                <td style="padding-bottom: 0.5rem">
                    Copyright © 2021. All rights reserved.
                </td>
                </tr>
                <tr>
                <td>Everest Car Rentals</td>
                </tr>
            </table>
            </td>
        </tr>
    </table>
  </body>
</html>
