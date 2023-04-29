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

        @page { margin: 0px; }

        .border-blue {
            border-color: #164c7a !important;
        }
        .text-blue {
            color: rgb(30 66 159 / 1);
        }
    </style>
</head>
<body class="p-2 text-blue">
    @foreach($item->passengers as $passenger)
    <div class="border-2 w-full mb-10">
        <table>
            <tr>
                <td>
                    <img src="images/left-ticket1.png" style="height: 385px; width: 80px">
                </td>
                <td class="text-xl p-4" style="width: 25%;">
                    <div style="margin-bottom: 10px">
                        <div>Pessanger</div>
                        <div class="font-bold">{{ $passenger->name }}</div>
                        <div class="border-b-2 border-dotted border-blue"></div>
                    </div>
                    <table class="w-full" style="margin-bottom: 10px">
                        <tr class="border-b-2 border-dotted border-blue">
                            <td class="px-2 pl-0">
                                <div>Check In</div>
                                <div class="font-bold">{{ $item->item->departure_time }}</div>
                            </td>
                            <td class="px-2">
                                <div>Port</div>
                                <div class="font-bold"> - </div>
                            </td>
                            <td class="px-2">
                                <div>Marine</div>
                                <div class="font-bold">{{ $item->item->group->fastboat->number }}</div>
                            </td>
                        </tr>
                    </table>
                    <table class="w-full border-b-2 border-dotted border-blue" style="margin-bottom: 10px">
                        <tr>
                            <td class="px-2 pl-0">
                                <div>Date</div>
                                <div class="font-bold">{{ $item->date_dot_formated }}</div>
                            </td>
                            <td class="px-2">
                                <div>From</div>
                                <div class="font-bold">{{ $item->item->source->name }}</div>
                            </td>
                        </tr>
                    </table>
                    <div class="flex flex-row border-b-2 border-dotted border-blue" style="margin-bottom: 10px">
                        <div class="flex flex-col">
                            <div>To</div>
                            <div class="font-bold">{{ $item->item->destination->name }}</div>
                        </div>
                    </div>
                    <table class="w-full">
                        <tr>
                            <td class="px-2 pl-0">
                                <div>Seat</div>
                                <div class="font-bold"> - </div>
                            </td>
                            <td class="px-2">
                                <div>Group</div>
                                <div class="font-bold"> - </div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="border-r-2 border-dotted border-blue" style="width: 1%">
                </td>
                <td class="px-4 ">
                    <div class="text-4xl font-bold">EKONOMI</div>
                    <img src="images/boat-ticket.png" class="h-[285px] w-fit"/>
                    <div class="text-base">
                        Please watch the departure board for the boarding & gate update boarding ends 60 min before departure
                    </div>
                </td>
                <td class="text-xl">
                    <div class="p-4 rounded-3xl rounded-r-none flex flex-col justify-between" style="background-image: url('images/blue.png');color: white">
                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('WLLNDN29042023', 'PDF417', 10, 4, [255,255,255]) }}"/>
                        <div class="">
                            <div>Pessanger</div>
                            <div class="font-bold">{{ $passenger->name }}</div>
                            <div class="border-b-2 border-dotted border-blue"></div>
                        </div>
                        <table class="w-full">
                            <tr class="border-b-2 border-dotted border-blue">
                                <td class="px-2 pl-0">
                                    <div>Departure Time</div>
                                    <div class="font-bold">{{ $item->item->arrival_time }}</div>
                                </td>
                                <td class="px-2">
                                    <div>Gate</div>
                                    <div class="font-bold"> - </div>
                                </td>
                                <td class="px-2">
                                    <div>Ferry</div>
                                    <div class="font-bold">{{ $item->item->group->fastboat->number }}</div>
                                </td>
                            </tr>
                        </table>
                        <table class="w-full">
                            <tr class="border-b-2 border-dotted border-blue">
                                <td class="px-2 pl-0">
                                    <div>From</div>
                                    <div class="font-bold">{{ $item->item->source->name }}</div>
                                </td>
                                <td class="px-2">
                                    <div>To</div>
                                    <div class="font-bold">{{ $item->item->destination->name }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    @endforeach
</body>
</html>