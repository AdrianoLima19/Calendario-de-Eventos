<?php

// Set the timezone
date_default_timezone_set('America/Sao_Paulo');

// Initialize a connection with the database
include "../../connection.php";

// Verify if exists some event on the database
$sql = "SELECT * FROM `tb_events` ORDER BY `start`";
$query = $connect -> query($sql);
$connect = NULL;

$today = date('Y-m-d');

if($query->rowCount() == 0) {
    include_once "loadClick.php";
    echo "data = ['$tableList']";
    return;
}
// Verify if exists some event on the database

// Get the Month 
if (isset($_GET['ym'])) {

    $ym = $_GET['ym'];

} else {

    $ym = date('Y-m');
    
}

// Get the Month 

$pm = date('Y-m', strtotime('- 1 month', strtotime($ym)));
$nm = date('Y-m', strtotime('+ 1 month', strtotime($ym)));
$timestamp = strtotime($ym);


// Checks if there are any events in the month, if it has generates an array with the event data
$repeat = 'reset';
$repeatMonth = 'reset';
foreach ($query as $event) {
    
    $start  = explode(" ", $event['start']);
    $end    = explode(" ", $event['end']);

    $vS = date('Y-m', strtotime($start[0])); // Verify Start
    $vE = date('Y-m', strtotime($end[0]));   // Verify End
    
    if( $ym == $vS || $ym == $vE || $nm == $vS || $pm == $vS) {
        
        $id              = $event['event_id']; 
        $title           = $event['title'];
        $startDay        = $start[0];
        $endDay          = $end[0];

        if($event['type'] == "tv") { $bgc = "background:rgba(100,151,177,79)"; $color = "background:rgba(100,151,177,79);color:white"; } else 
        if($event['type'] == "tc") { $bgc = "background:rgba(69,103,137,79)";  $color = "background:rgba(69,103,137,79);color:white;"; } else
        if($event['type'] == "ti") { $bgc = "background:rgba(3,91,150,231)";   $color = "background:rgba(3,91,150,231);color:white;";  } else 
        if($event['type'] == "te") { $bgc = "background:rgba(4,57,108,223)";   $color = "background:rgba(4,57,108,223);color:white;";  } else 
        if($event['type'] == "tp") { $bgc = "background:rgba(3,31,75,222)";    $color = "background:rgba(3,31,75,222);color:white;";   } else 
                                   { $bgc = "background:rgba(100,151,177,79)"; $color = "background:rgba(100,151,177,79);color:white"; }

        $eventList[] = [

            'id'              => $id,
            'title'           => $title,
            'startDay'        => $startDay,
            'endDay'          => $endDay,
            'color'           => $color,
            'bgc'             => $bgc,
        ];

        $date1 = new DateTime($startDay);
        $date2 = new DateTime($endDay);
        $interval = date_diff($date1, $date2);
        $interval = intval($interval->format('%a')) + 1;

        for ($i=0; $i < $interval; $i++) {
            $vm = date('m', strtotime("+ $i day", strtotime($startDay))); // Verify month

            if ($repeat != $id || $repeatMonth == $vm) {

                $eventDay[$id][] = [
                    'day' => date('Y-m-d', strtotime("+ $i day", strtotime($startDay))),
                    'id' => $id,
                    'continuation' => false,
                ];

            } else if ($repeat == $id && $repeatMonth != $vm){

                $eventDay[$id][] = [
                    'day' => date('Y-m-d', strtotime("+ $i day", strtotime($startDay))),
                    'id' => $id,
                    'continuation' => false,
                ];

            } else {

                $eventDay[$id][] = [
                    'day' => date('Y-m-d', strtotime("+ $i day", strtotime($startDay))),
                    'id' => $id,
                    'continuation' => true,
                ];

            }

            $repeat = $id;
            $repeatMonth = $vm;

        }
    }

}
// Checks if there are any events in the month, if it has generates an array with the event data

// Returns null if there are no events in the month.
if (!isset($eventList)) {
    include_once "loadClick.php";
    echo "data = ['$tableList']";
    return;
}
// Returns null if there are no events in the month.

$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$prev_count = date('t', strtotime($prev . '-01'));
$day_count = date('t', $timestamp);
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
$weeks = array();
$week = '';

// generate the previous month
$antes_add = $str;
if ($antes_add) {
    while ($antes_add) {

        $inverso[] = $prev_count;
        $prev_count--;
        $antes_add--;

    }
    for ($i = count($inverso)-1; $i >= 0; $i--) {

        $date = date('Y-m-d', mktime(0, 0, 0, date('m', $timestamp)-1, $inverso[$i], date('Y', $timestamp)));
        $week .= $date.';';

    }
}

// generate current month
for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
    $date = date('Y-m-d', strtotime($ym . '-' . $day));
    $week .= $date.';';

    $day_after = 1;
    
    if ($str % 7 == 6 || $day == $day_count) {
        
        if ($day == $day_count) {
            
            $after_add = 6 - ($str % 7);
            
            while ($after_add) {

                $date = date('Y-m-d', mktime(0,0,0, date('m', $timestamp) + 1, $day_after, date('Y', $timestamp)));
                $week .= $date.';';
                
                $after_add--;
                $day_after++;

            }
        }

        $weeks[] = $week;
        $week = '';
    }
}

// generates the sixth week if it does not exist
if (empty($weeks[5])) {

    for ($x = 0; $x <=6; $x++) {
        
        $date = date('Y-m-d', mktime(0,0,0, date('m', $timestamp) + 1, $day_after, date('Y', $timestamp)));
        $week .= $date.';';
        
        $day_after++;

    }

    $weeks[] = $week;
    
}

// separates the month into units
foreach ($weeks as $week ) {

    $month[] = explode(";", $week);

}

for ($week=0;$week<=5;$week++)  {
    for ($day=0;$day<=6;$day++) {

        $layout2[$week][$day] = $month[$week][$day];
        $layout1[$week][$day] = $month[$week][$day];
        
        $tr1[$week][$day] = 'reset';
        $tr2[$week][$day] = 'reset';
        $tr3[$week][$day] = 'reset';

        $dropdown[$week][$day] = '';
        $dropList[$week][$day] = '<div class="list"> <ul>';
        
        $event1[$week][$day] = '';
        $event2[$week][$day] = '';

        $color1[$week][$day] = '';
        $color2[$week][$day] = '';

    }
}

$listar1 = '';
$listar2 = '';
$leftEventID = array();
$leftEvent = '';
$leftRepeat = 'reset';
$dropRepeat = 'reset';
for ($week=0;$week<=5;$week++)  {
    
    for ($day=0;$day<=6;$day++) {

        $sum = 1;
        $date = $month[$week][$day];

        foreach ($eventDay as $list) {
            foreach ($list as $key ) {
                
                if ( strtotime($date) == strtotime($key['day']) ) {

                    if ($leftRepeat != $key['id']) {
                        $leftEventID[] = $key['id'];
                        $leftRepeat = $key['id'];
                    }

                    if ( $layout1[$week][$day] == 'occupied' && $layout2[$week][$day] == 'occupied' ) {
                        
                        $tr3[$week][$day] = $sum++;

                        if ($dropRepeat != $key['id']) {

                            $dropdown[$week][$day] .= $key['id'].',';
                            $dropRepeat = $key['id'];

                        }

                    } else if ($layout1[$week][$day] != 'occupied') {
                        
                        if ($listar1 == $key['id']) {
                            
                            $tr1[$week][$day] = $key['id'];
                            $layout1[$week][$day] = 'occupied';
                            $listar1 = $key['id'];

                        } else if ($listar2 == $key['id']) {
                            
                            $tr2[$week][$day] = $key['id'];
                            $layout2[$week][$day] = 'occupied';
                            $listar2 = $key['id'];

                        } else if (!$key['continuation']) {
                            
                            $tr1[$week][$day] = $key['id'];
                            $layout1[$week][$day] = 'occupied';
                            $listar1 = $key['id'];

                        }

                    } else if ($layout2[$week][$day] != 'occupied') {
                        
                        if ($listar2 == $key['id']) {
                            
                            $tr2[$week][$day] = $key['id'];
                            $layout2[$week][$day] = 'occupied';
                            $listar2 = $key['id'];

                        } else if (!$key['continuation']) {
                            
                            $tr2[$week][$day] = $key['id'];
                            $layout2[$week][$day] = 'occupied';
                            $listar2 = $key['id'];
                            
                        }
                    }
                }
            }
        }
    }
}

// Translate ID to names
foreach ($eventList as $event ) {
    for ($week=0;$week<=5;$week++)  {
        for ($day=0;$day<=6;$day++) {
            if($event['id'] == $tr1[$week][$day]) {

                $event1[$week][$day] = utf8_encode($event['title']);
                $color1[$week][$day] = $event['color'];

            } else if($event['id'] == $tr2[$week][$day]) {
                $event2[$week][$day] = utf8_encode($event['title']);
                $color2[$week][$day] = $event['color'];
            }
        }
    }
    foreach ($leftEventID as $key) {
        if ($key == $event['id']) {
            $leftEvent .= '<div class="leftEventBlock" style="'.$event['bgc'].'">';
            $leftEvent .= '<div class="eventName">';
            $leftEvent .= '<h4 class="leftEvent">'.utf8_encode($event['title']).'</h4>';
            $leftEvent .= '</div>';
            $leftEvent .= '<div class="imgOpts">';
            $leftEvent .= '<img src="../images/notes.png" data-name="'.utf8_encode($event['title']).'" data-id="'.$event['id'].'" title="editar '.utf8_encode($event['title']).'">';
            $leftEvent .= '</div>';
            $leftEvent .= '<div class="imgOpts">';
            $leftEvent .= '<img src="../images/delete.png" data-name="'.utf8_encode($event['title']).'" data-id="'.$event['id'].'" title="deletar '.utf8_encode($event['title']).'">';
            $leftEvent .= '</div>';
            $leftEvent .= '</div>';
        }
    }
}
for ($week=0;$week<=5;$week++)  {
    for ($day=0;$day<=6;$day++) {

        $explode = explode(',', $dropdown[$week][$day]);
        
        foreach ($explode as $id) {

            foreach ($eventList as $event ) {
                
                if ($event['id'] == $id) {
                    
                    $dropList[$week][$day] .= '<li><div> <h5 style="'.$color1[$week][$day].'"> '.utf8_encode($event['title']).' </h5> </div></li>';

                }
            }
            
        }
        
        $dropList[$week][$day] .= '</ul> </div>';

    }
}
// Translate ID to names

$show = '';

for ($week=0;$week<=5;$week++)  {

    $show .= '<table class="event-table" >';

    $show .= '<tr>';
    for ($day=0;$day<=6;$day++) {

        if(strtotime($month[$week][$day]) >= strtotime($today)) {
            $show .= '<td> <div class="thisDay" data-date="'.$month[$week][$day].'"></div></td>';
        } else {
            $show .= '<td> <div class="outDay"></div></td>';
        }

    }
    $show .= '</tr>';
    
    // TR1

    $get = 'reset';
    $getC = 0;
    $td = "";
    $memo = "reset";

    $show .= '<tr>';
    
    for ($day=0;$day<=6;$day++) {
        
        if ($tr1[$week][$day] == 'reset') {

            if (empty($td)) {

                $getC++;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            } else if ($memo == 'reset'){

                $getC++;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            } else {

                $show .= $td;
                $getC = 1;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            }
            
        } else if ($tr1[$week][$day] != 'reset'){

            if ($tr1[$week][$day] == $memo) {

                if (empty($td)) {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr1[$week][$day].'"> <div><h6 style="'.$color1[$week][$day].'"> '.$event1[$week][$day].' </h6></div> </td>';
                    $memo = $tr1[$week][$day];

                } else {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr1[$week][$day].'"> <div><h6 style="'.$color1[$week][$day].'"> '.$event1[$week][$day].' </h6></div> </td>';
                    $memo = $tr1[$week][$day];

                }

            } else if ($tr1[$week][$day] != $memo) {

                if (empty($td)) {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr1[$week][$day].'"> <div><h6 style="'.$color1[$week][$day].'"> '.$event1[$week][$day].' </h6></div> </td>';
                    $memo = $tr1[$week][$day];

                } else {

                    $show .= $td;
                    $getC = 1;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr1[$week][$day].'"> <div><h6 style="'.$color1[$week][$day].'"> '.$event1[$week][$day].' </h6></div> </td>';
                    $memo = $tr1[$week][$day];

                }
            }
        }
    }

    $show .= $td.'</tr>';

    // TR1

    // TR2

    $get = 'reset';
    $getC = 0;
    $td = "";
    $memo = "reset";

    $show .= '<tr>';
    
    for ($day=0;$day<=6;$day++) {
        
        if ($tr2[$week][$day] == 'reset') {

            if (empty($td)) {

                $getC++;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            } else if ($memo == 'reset'){

                $getC++;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            } else {

                $show .= $td;
                $getC = 1;
                $td = '<td colspan="'.$getC.'">  </td>';
                $memo = 'reset';

            }
            
        } else if ($tr2[$week][$day] != 'reset'){

            if ($tr2[$week][$day] == $memo) {

                if (empty($td)) {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr2[$week][$day].'"> <div><h6 style="'.$color2[$week][$day].'"> '.$event2[$week][$day].' </h6></div> </td>';
                    $memo = $tr2[$week][$day];

                } else {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr2[$week][$day].'"> <div><h6 style="'.$color2[$week][$day].'"> '.$event2[$week][$day].' </h6></div> </td>';
                    $memo = $tr2[$week][$day];

                }

            } else if ($tr2[$week][$day] != $memo) {

                if (empty($td)) {

                    $getC++;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr2[$week][$day].'"> <div><h6 style="'.$color2[$week][$day].'"> '.$event2[$week][$day].' </h6></div> </td>';
                    $memo = $tr2[$week][$day];

                } else {

                    $show .= $td;
                    $getC = 1;
                    $td = '<td colspan="'.$getC.'" class="event-list" data-date="'.$tr2[$week][$day].'"> <div><h6 style="'.$color2[$week][$day].'"> '.$event2[$week][$day].' </h6></div> </td>';
                    $memo = $tr2[$week][$day];

                }
            }
        }
    }
    $show .= $td.'</tr>';

    // TR2

    // TR3

    $show .= '<tr>';
    
    for ($day=0;$day<=6;$day++) {
        
        if ($tr3[$week][$day] == 'reset') {
            
            $show .= '<td> <div> <ul class="unlist"></ul> </div> </td>';
            

        } else if ($tr3[$week][$day] != 'reset') {

            if ($tr3[$week][$day] == 1) {
                $show .= '<td class="more-event"> <div> <input id="btn-show-more" type="button" value="+ '.$tr3[$week][$day].' evento"> '.$dropList[$week][$day].' </div> </td>';
            } else {
                $show .= '<td class="more-event"> <div> <input id="btn-show-more" type="button" value="+ '.$tr3[$week][$day].' eventos"> '.$dropList[$week][$day].' </div> </td>';
            }
            
            
        }
    }

    $show .= '</tr>';

    // TR3
    
    $show .= '</table>';
}

echo "data = ['$show', '$leftEvent']";
