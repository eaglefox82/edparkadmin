<!DOCTYPE html>
<html>
<head>
    <!-- Theme style -->
    <style>
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

    <div id="barcodeTarget" class="barcodeTarget" style="margin: auto"></div>

    <br>
    <br>
    <br>
    <br>
    <br>
    <hr>

    <script src="{{ asset('styles/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('styles/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('styles/js/jquery-barcode.js') }}"></script>
    <script src="{{ asset('styles/js/jquery-barcode.min.js') }}"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            const value = "{{$registration->member->cert_no}}";
            const btype = "code39";
            const renderer = "css";

            const settings = {
                output: renderer,
                bgColor: '#FFFFFF',
                color: '#000000',
                barWidth: '3',
                barHeight: '100',
                moduleSize: '5',
                posX: '20',
                posY: '20',
                addQuietZone: '1'
            };

            $("#barcodeTarget").html("").show().barcode(value, btype, settings);

            window.print();
        });

    </script>
</body>
</html>
