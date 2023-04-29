<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    
    <title>Ticket</title>
    {{-- @vite(['resources/js/frontpage.jsx']) --}}
    @php
        $manifest = \File::json(public_path('/build/manifest.json'));
        $appCss = \File::get(public_path('/build/'.$manifest['resources/css/app.css']['file']));
    @endphp
    <style>
        {!! $appCss !!}
    </style>
    {{-- <link rel="stylesheet" href="{{ asset('pdf/style.css') }}"> --}}
</head>
<body class="p-2 text-blue-800">
    <div class="border-2 w-full flex flex-row">
        <div>
            <img src="images/left-ticket1.png" class="h-[490px] w-40">
        </div>
        <div class="flex flex-col h-full p-8 pr-16 text-xl space-y-5 min-w-[400px]">
            <div class="flex flex-col space-y-1">
                <div>Pessanger</div>
                <div class="font-bold">NAME</div>
                <div class="border-b-2 border-dotted border-blue-800"></div>
            </div>
            <div class="flex flex-row justify-between border-b-2 border-dotted border-blue-800">
                <div class="flex flex-col space-y-1">
                    <div>Check In</div>
                    <div class="font-bold">09.00 AM</div>
                </div>
                <div class="flex flex-col space-y-1">
                    <div>Port</div>
                    <div class="font-bold">1</div>
                </div>
                <div class="flex flex-col space-y-1">
                    <div>Marine</div>
                    <div class="font-bold">A1</div>
                </div>
            </div>
            <div class="flex flex-row justify-between space-x-5 border-b-2 border-dotted border-blue-800">
                <div class="flex flex-col">
                    <div>Date</div>
                    <div class="font-bold">15.03.2023</div>
                </div>
                <div class="flex flex-col">
                    <div>From</div>
                    <div class="font-bold">Padang Bai</div>
                </div>
            </div>
            <div class="flex flex-row border-b-2 border-dotted border-blue-800">
                <div class="flex flex-col">
                    <div>To</div>
                    <div class="font-bold">Gili Trawangan</div>
                </div>
            </div>
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <div>Seat</div>
                    <div class="font-bold">15</div>
                </div>
                <div class="flex flex-col">
                    <div>Group</div>
                    <div class="font-bold">D</div>
                </div>
            </div>
        </div>
        <div class="min-h-full border-r-2 border-dotted border-blue-800"></div>
        <div class="flex flex-col h-full p-4 space-y-5">
            <div class="text-4xl font-bold">EKONOMI</div>
            <img src="/images/boat-ticket.png" class="h-[285px] w-fit"/>
            <div class="text-base">
                Please watch the departure board for the boarding & gate update boarding ends 60 min before departure
            </div>
        </div>
        <div class="flex flex-col h-full p-4 pr-0 text-xl">
            <div class="text-white bg-blue-800 p-4 rounded-xl rounded-r-none flex flex-col justify-between min-h-[400px]">
                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('4445645656', 'PDF417', 10, 5, [255,255,255]) }}"/>
                <div class="flex flex-col space-y-1 ">
                    <div>Pessanger</div>
                    <div class="font-bold">NAME</div>
                    <div class="border-b-2 border-dotted border-white"></div>
                </div>
                <div class="flex flex-row justify-between border-b-2 border-dotted border-white">
                    <div class="flex flex-col space-y-1">
                        <div>Departure Time</div>
                        <div class="font-bold">10.00 AM</div>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <div>Gate</div>
                        <div class="font-bold">1</div>
                    </div>
                    <div class="flex flex-col space-y-1">
                        <div>Ferry</div>
                        <div class="font-bold">A1</div>
                    </div>
                </div>
                <div class="flex flex-row justify-between space-x-5">
                    <div class="flex flex-col">
                        <div>From</div>
                        <div class="font-bold">Gili Trawangan</div>
                    </div>
                    <div class="flex flex-col">
                        <div>To</div>
                        <div class="font-bold">Padang Bai</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>