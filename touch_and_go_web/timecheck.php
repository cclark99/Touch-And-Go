<!-- timecheck.php
 SELECT *
 FROM checkin_table
 WHERE DAYOFWEEK(checkin_datetime) = 3
   AND TIME(checkin_datetime) BETWEEN '10:00:00' AND '14:00:00'
   AND checkin_datetime BETWEEN '2023-01-01' AND '2023-01-31'; -->
