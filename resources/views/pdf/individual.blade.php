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
            <h2>{{$data['instance']}}</h2>
            <h4>{{$data['lecturer']}}</h4>
            <p class="key">Key: <span style="background-color: #93e07e;">Lab</span> | <span style="">Lecture</span> | <span style="background-color: #e0e0e0;">Break</span></p>
        </div>
        <table>
            <thead>
                <tr>
                    <th></th> 
                    <th>07:00 - 08:00</th>
                    <th>08:00 - 09:00</th>
                    <th>09:00 - 10:00</th>
                    <th>10:00 - 11:00</th>
                    <th>11:00 - 12:00</th>
                    <th>12:00 - 13:00</th>
                    <th>13:00 - 14:00</th>
                    <th>14:00 - 15:00</th>
                    <th>15:00 - 16:00</th>
                    <th>16:00 - 17:00</th>
                    <th>17:00 - 18:00</th>
                    <th>18:00 - 19:00</th>
                </tr>
            </thead>
            <tbody id="my-tbody">
                @foreach($lecturer_schema->keyBy('day_of_week') as $day => $slot)
                <tr>
                    <td class="day" colspan="1">{{$day}}</td>
                    @php  
                        $slots = $lecturer_schema->where('day_of_week', $day)->groupBy('start_time');
                        $slots = $slots->sortBy('start_time');
                        $colspan = 1;
                        $prev_slot = null;
                        foreach ($slots as $slot) {
                            if ($prev_slot !== null && $prev_slot[0]['unit_name'] === $slot[0]['unit_name'] && $prev_slot[0]['unit_code'] === $slot[0]['unit_code'] && $prev_slot[0]['building'] === $slot[0]['building'] && $prev_slot[0]['room_name'] === $slot[0]['room_name'] && $prev_slot[0]['group'] === $slot[0]['group'] && $prev_slot[0]['lab_name'] === $slot[0]['lab_name'] && $slot[0]['group'] !== null) {
                                $colspan++;
                            } else {
                                if ($prev_slot !== null) {
                                    if($colspan > 1) {
                                        echo '<td colspan="'.$colspan.'"';
                                        if ($prev_slot[0]['lab_name'] == null) {
                                        } else {
                                            echo ' style="background-color: #93e07e;"';
                                        }
                                        echo '>' 
                                            . $prev_slot[0]['unit_name'] .
                                            '<br>' . $prev_slot[0]['unit_code'] .
                                            '<br><b>' . $prev_slot[0]['building'] . '</b>: ' . $prev_slot[0]['room_name'] .
                                            '<br>' . $prev_slot[0]['group'].'</td>';
                                    }
                                    else {
                                        echo '<td class="break"></td>';
                                    }
                                }
                                $colspan = 1;
                            }
                            $prev_slot = $slot;
                        }
                        if ($prev_slot !== null) {
                            echo '<td class="break"></td>';
                        }
                    @endphp
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
