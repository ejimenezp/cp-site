
<div class="row" id="cp-week-buttons">
    <button class="btn btn-primary" onclick="location.href='/admin/calendar/{{date('Y-m-d') }}'">Today</button>
<?php
    $datetime_week_start = clone $datetime;
    $datetime_week_start->sub(new DateInterval("P".strval (($datetime->format("w") + 6) % 7)."D"));        
    $datetime_week_end = clone $datetime;
    $datetime_week_end->add(new DateInterval("P".strval ((7 - ($datetime->format("w")))% 7 )."D"));
    $previous_week = clone $datetime;
    $previous_week->sub(new DateInterval("P1W"));
    $next_week = clone $datetime;
    $next_week->add(new DateInterval("P1W"));
?>

<button class="btn btn-primary" onclick="location.href='/admin/calendar/ <?php echo $previous_week->format('Y-m-d') ?>'"><<</button>
<button class="btn btn-primary" onclick="location.href='/admin/calendar/ <?php echo $next_week->format('Y-m-d') ?>'">>></button>

<?php
     echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;' . $datetime_week_start->format("d M") . ' - ' . $datetime_week_end->format("d M") . '</p>'    
?>

</div>
<table class="table" id="cp-week">
	<thead>
        <tr>
        <?php 



        $d = clone $datetime_week_start;
        while ($d <= $datetime_week_end) {
            echo '<th>'. $d->format("D") .'<br/>'. $d->format("j M") .'</th>';
            $d->modify("+1 day");
        }
        
        ?>
        </tr>
</thead>
<tbody>
        <tr> 
        <?php 

        use App\CalendarEvent;

        $d = clone $datetime_week_start;
        while ($d <= $datetime_week_end) {
            echo '<td class="cp-day">';
            $ts = CalendarEvent::ts_timestamp($d->format("Y-m-d"),'am');
            if (isset ($slots[$ts])) {
                if (sizeof($slots[$ts]) == 1) {
                    echo '<a href="/admin/calendarevent/new/'. $d->format('Y-m-d') .'/am">&nbsp;</a>';
                } else {
                    foreach ($slots[$ts] as $a => $event) {
                        if ($event->id != 0) {
                            echo '<a href="/admin/calendarevent/'. $d->format('Y-m-d') .'/'. $event->id .'">'.$event->activity->shortcode . '</a>';
                        }
                    }
                }
            }            
            echo '</td>';
            $d->modify("+1 day");
        }
        
        ?>
        </tr>

        <tr> 
        <?php 

        $d = clone $datetime_week_start;
        
        while ($d <= $datetime_week_end) {
            echo '<td class="cp-day">';
            $ts = CalendarEvent::ts_timestamp($d->format("Y-m-d"),'pm');
            if (isset ($slots[$ts])) {
                if (sizeof($slots[$ts]) == 1) {
                    echo '<a title="new event" href="/admin/calendarevent/new/'. $d->format('Y-m-d') .'/pm">&nbsp;</a>';
                } else {
                    foreach ($slots[$ts] as $a => $event) {
                        if ($event->id != 0) {
                            echo '<a href="/admin/calendarevent/'. $d->format('Y-m-d') .'/'. $event->id .'">'.$event->activity->shortcode . '</a>';
                        }
                    }
                }
            }            
            echo '</td>';
            $d->modify("+1 day");
        }
        
        ?>
        </tr>
        
</tbody>
</table>
