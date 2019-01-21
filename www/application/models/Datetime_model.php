<?php
class Datetime_model extends CI_Model
{
    public function get_reccuring_dates($data, $step, $unit, $period)
    {
        $result = [];

        $reservation_start = new DateTime($data['start_time']);
        $reservation_end = new DateTime($data['end_time']);

        // Define holidays here (day-month format)
        $holidays = array(
            '01-01'
        );

        // Set how long it runs
        $repeat_end = new DateTime(date('Y-m-d H:i:s', strtotime("+$period months", strtotime($data['start_time']))));

        // How often it should repeat
        $interval = new DateInterval("P{$step}{$unit}");

        // Generate the dates
        $period_start_dates = new DatePeriod($reservation_start, $interval, $repeat_end);
        $period_end_dates = new DatePeriod($reservation_end, $interval, $repeat_end);

        // Combine the date arrays into one
        foreach ($period_start_dates as $key => $date ) {
            $dayOfWeek = $date->format('N');
            if( $dayOfWeek < 6 ){
                // If the day of the week is not a pre-defined holiday
                $format = $date->format('d-m');
                if(!in_array( $format, $holidays)){
                    //Add the valid day to our days array
                    $result['reservations'][$key]['start'] = $date->format('Y-m-d H:i:s');
                }
            }
        }
        foreach ($period_end_dates as $key => $date) {
            $dayOfWeek = $date->format('N');
            if( $dayOfWeek < 6 ){
                // If the day of the week is not a pre-defined holiday
                $format = $date->format('d-m');
                if(!in_array( $format, $holidays)){
                    //Add the valid day to our days array
                    $result['reservations'][$key]['end'] = $date->format('Y-m-d H:i:s');
                }
            }
        }
        // Add extra data needed for parent reservation
        $last_element = end($result['reservations']);
        $result['first_start_date'] = $data['start_time'];
        $result['last_end_date'] = $last_element['end'];

        // Return the end result
        return $result;
    }
    
    public function time_difference($start, $end)
    {
        $start_time = new DateTime($start);
        $end_time = new DateTime($end);
        $interval = $start_time->diff($end_time);
        return $interval;
    }

    public function add_time($date, $interval)
    {   
        // Build the period needed for DateInterval
        $year = $interval->format("%y");
        $month = $interval->format("%m");
        $day = $interval->format("%d");
        $hour = $interval->format("%h");
        $min = $interval->format("%i");
        $sec = $interval->format("%s");

        $period = "P{$year}Y{$month}M{$day}DT{$hour}H{$min}M{$sec}S";
        $new_date = new DateTime($date);
        $new_date->add(new DateInterval($period));
        return $new_date->format('Y-m-d H:i:s');
    }
}