<?php

date_default_timezone_set('America/Sao_Paulo');

function dataList($now, $date, $day, $type) {
    
    if ($now <= $date) {
        return '<td> <div class="thisDay" data-date="'.$date.'"></div></td>';
    } else {
        return '<td> <div class="outDay"></div></td>';
    }
    
}

if (isset($_GET['ym'])) {
    $ym = $_GET['ym'];
} else {
    $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');

$today = date('Y-m-d');

$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

$prev_count = date('t', strtotime($prev . '-01'));
$day_count = date('t', $timestamp);

// 0:D 1:S 2:T ... 6:S
$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));

$weeks = array();
$week = '';

// generate the previous tableList
$antes_add = $str;
if ($antes_add) {
    while ($antes_add) {

        $inverso[] = $prev_count;
        $prev_count--;
        $antes_add--;

    }
    for ($i = count($inverso)-1; $i >= 0; $i--) {

        $date = $data_antes = date('Y-m-d', mktime(0, 0, 0, date('m', $timestamp)-1, $inverso[$i], date('Y', $timestamp)));

        $week .= dataList($today,$date,$inverso[$i],'day-out');

    }
}

// add this tableList
for ( $day = 1; $day <= $day_count; $day++, $str++) {
    
    $date = date('Y-m-d', strtotime($ym . '-' . $day));

    $week .= dataList($today,$date,$day,'day');

    // weekend or tableList
    $day_after = 1;
    
    if ($str % 7 == 6 || $day == $day_count) {
        
        if ($day == $day_count) {
            
            // add later tableList
            $after_add = 6 - ($str % 7);
            
            while ($after_add) {

                $date = date('Y-m-d', mktime(0,0,0, date('m', $timestamp) + 1, $day_after, date('Y', $timestamp)));

                $week .= dataList($today,$date,$day_after,'day-out');
                
                $after_add--;
                $day_after++;

            }
        }

        // prepare for new week
        $weeks[] = $week;
        $week = '';
    }
}

// adds a sixth week if it does not exist
if (empty($weeks[5])) {

    for ($x = 0; $x <=6; $x++) {
        
        $date = date('Y-m-d', mktime(0,0,0, date('m', $timestamp) + 1, $day_after, date('Y', $timestamp)));

        $week .= dataList($today,$date,$day_after,'day-out');
        
        $day_after++;

    }
}

$weeks[] = $week;

// output control
$tableList = '';

for ($week=0; $week <=5; $week++) {

    $tableList .= '<table class="event-table">';
    $tableList .= '<tr>';
    $tableList .= $weeks[$week];
    $tableList .= '</tr>';

    $tableList .= '<tr></tr><tr></tr><tr></tr>';
    $tableList .= '</table>';

}