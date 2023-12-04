<!DOCTYPE html>
<html>
<head>
    <!-- Theme style -->
    <style>
        body, header {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .text-center {
            text-align: center;
        }

        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 0px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 8px;
        }

        h3 {
            margin: 10px !important;
        }

        @media print
        {
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
</head>
<body>
    <h2 class="text-center">
        {{ $registration->member->last_name }}, {{ $registration->member->first_name }}
    </h2>
    <h3 class="text-center">
        {{ $registration->member->unit }}
    </h3>
    <h3 class="text-center">
        {{ $registration->member->cert_no }}
    </h3>

    <div id="barcodeTarget" class="barcodeTarget text-center" style="margin: auto"></div>

    <br>
    <br>
    <hr>

    <script src="{{ asset('styles/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('styles/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('styles/js/qr/qrcode.js') }}"></script>
    <script src="{{ asset('styles/js/qr/qrcode.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            new QRCode(document.getElementById("barcodeTarget"), {
                text: "{{$registration->member->cert_no}}",
                width: 128,
                height: 128,
            });

            window.print();
        });

    </script>
</body>
</html>
