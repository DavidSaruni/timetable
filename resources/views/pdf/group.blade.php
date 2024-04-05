<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ccc;
                padding-top: 3px;
                padding-bottom: 3px;
                padding-left: 8px;
                padding-right: 8px;
                text-align: center;
            }
            th {
                background-color: #f2f2f2;
            }
            .break {
                background-color: #e0e0e0;
            }
            .blank {
                background-color: #fff;
            }
            .center {
                text-align: center;
            }
            .day {
                font-weight: bold;
                background-color: #f2f2f2;
            }
            .chapel {
                font-weight: bold;
            }
            .left{
                text-align:left;
                float:left;
                padding: 10px 20px; 
                font-size: 11px;
            }
            .right{
                float:right;
                text-align:right;
                padding: 10px 20px; 
                font-size: 11px;
            }
            .l{
                float:left;
                width:50%;
            }
            .r{
                float:right;
                width:50%;
            }
            .zero-line-spacing {
                line-height: 0.5;
            }
        </style>
    </head>
    <body>
        <div class="center zero-line-spacing">
            <h3>{{$data['school_name']}}</h3>
            <h4>{{$data['instance']}}</h4>
            <h5>{{$data['cohort_name']}}</h5>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th> 
                    @foreach($skeleton as $slot)
                        @if($slot['break'] == 'no')
                            <th>{{substr($slot['start_time'], 0, 5)}} - {{substr($slot['end_time'], 0, 5)}}</th>
                        @else
                            <th class="break">{{substr($slot['start_time'], 0, 5)}} - {{substr($slot['end_time'], 0, 5)}}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody id="my-tbody">
                @foreach($group_schema->keyBy('day_of_week') as $day => $slot)
                    @php
                        $day_slots = $cells->filter(function ($item, $key) use ($day) {
                            return $key === $day;
                        })->first();
                        // sort($day_slots) by start_time
                        $day_slots = $day_slots->sortBy('start_time');
                    @endphp
                    <tr>
                        <td class="day" colspan="1">{{$day}}</td>
                        @foreach($day_slots as $slot)
                            @if($slot['class'] == "break")
                                <td colspan="{{$slot['colspan']}}" class="break"></td>
                            @elseif($slot['class'] == "chapel")
                                <td colspan="{{$slot['colspan']}}" class="chapel">CHAPEL HOUR</td>
                            @else
                                <td colspan="{{$slot['colspan']}}">
                                    {{$slot['unit_name']}}
                                    <br>
                                    {{$slot['unit_code']}}
                                    <br>
                                    {{$slot['lecturer_name']}}
                                    <br>
                                    {{$slot['building']}} {{$slot['room_name']}}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <footer class="footer-row">
            <div class="l">
                <p class="left">Generated on: {{$data['gen']}}</p>
            </div>
            <div class="r">
                <p class="right">Printed by: {{Auth::user()->title}} {{Auth::user()->name}} on: {{date('Y-m-d H:i:s')}} (c) {{$data['instance_id']}}</p>
            </div>
        </footer>
        <script>
            const rows = document.querySelectorAll('#my-tbody tr');
            let maxHeight = 0;
            rows.forEach(row => {
                const height = row.clientHeight;
                if (height > maxHeight) {
                    maxHeight = height;
                }
            });
            rows.forEach(row => {
                row.style.height = `${maxHeight}px`;
            });
        </script>
    </body>
</html>
