<div id="cp-calendar">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3">
            <table width="100%">
                <?php 
                $first_day_of_month = new DateTime ($datetime->format("Y-m"));
                $days_in_month = cal_days_in_month(CAL_GREGORIAN, $datetime->format("m"), $datetime->format("Y"));
                $today = $datetime->format("d");
                
                $previous_month = clone $datetime;
                $previous_month->sub(new DateInterval("P1M"));

                $next_month = clone $datetime;
                $next_month->add(new DateInterval("P1M"));
                ?>
                
                <thead>
                    <tr>
                        <td><a href="/admin/calendar/<?php echo $previous_month->format("Y-m-d"); ?>"><<</a></td>
                        <td colspan="5" class="month"><?php echo $datetime->format("M Y"); ?></td>
                        <td><a href="/admin/calendar/<?php echo $next_month->format("Y-m-d"); ?>">>></a>
                    </tr>
                    <tr>
                        <td>Mo</td><td>Tu</td><td>We</td><td>Th</td><td>Fr</td><td>Sa</td><td>Su</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                <?php
                $pointer = clone $first_day_of_month;
                $j = 1;
                $i = 0;
                
                while ($i < ($first_day_of_month->format("w") + 6) % 7) {
                    echo '<td></td>';
                    $i++;
                }
                while ($j <= $days_in_month) {
                    if (($j+$i) % 7 == 1) {
                        echo '<tr>';
                    }
                    if ($j == $today) {
                        echo '<td class="today"><a href="/admin/calendar/'.$pointer->format("Y-m-d").'">'.$j.'</a></td>';
                        
                    } else {
                        echo '<td><a href="/admin/calendar/'.$pointer->format("Y-m-d").'">'.$j.'</a></td>';                   
                    }
                    if (($j+$i) % 7 == 0) {
                        echo '</tr>';
                    }
                    $j++;
                    $pointer->add(new DateInterval("P1D"));
                }
                   
                    
                
                
                ?>
                
               </tbody>
            </table>
            <div class="text-center">
                <button class="btn btn-xs btn-primary" onclick="location.href='/admin/calendar/{{date('Y-m-d') }}'">Today</button>
            </div>
        </div>
    </div>
</div>


