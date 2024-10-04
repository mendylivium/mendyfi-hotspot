<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Voucher</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.5/dist/cdn.min.js"></script>
    <style>
        @media print {
            #printTools {
                display: none;
            }
        }

        #printTools>button {
            margin-top: 0.5rem;
            margin-left: 0.5rem;
        }

        {!! $styleHTML !!}
    </style>
</head>

<body>

    <div x-data="{ vouchers: [] }" x-init="vouchers = await (await fetch('{{ route('api.vouchers.print', ['batch' => request()->get('batch')]) }}')).json()">
        <div id="printTools">
            <button x-on:click="window.print()">PRINT</button><br />
            <hr />
        </div>

        <template x-for="voucher in vouchers">
            {!! $bodyHTML !!}
        </template>
    </div>
</body>

</html>
