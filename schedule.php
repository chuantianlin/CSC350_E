<!DOCTYPE html>
<html>
  <head>
    <title>Schedule</title>
    <link rel="stylesheet" href="style3.css">
  </head>
  <body>
    <table border="">
      <tr class="time">
        <th>Monday</th>
        <th>Thusrday</th>
        <th>Wenesaday</th>
        <th>Thusrday</th>
        <th>Friday</th>
        <th>Saturday</th>
        <th>Sunday</th>
      </tr>
      <?php
      $row = 19;
      $col = 7;
      $empty = "--";
          for ($i=0; $i< $row ; $i++) {
            echo '<tr onmouseover="changeColor(this)" onmouseout="restoreColor(this)">';
            for ($z=1; $z <= $col; $z++) {
              echo '<td id="weekdays">';
              echo "- -";
              echo'</td>';
            }
            echo "</tr>";
          }
      ?>
    </table>
    <script type="text/javascript">
      var mainColor = " #F6FFF1";
      var thatColor = "#D4EFC4";
      var thisColor = "red";
      function changeColor(row){
        row.style.backgroundColor = thatColor;
      }
      function restoreColor(row) {
        row.style.backgroundColor = mainColor;
      }
    </script>
  </body>
</html>
