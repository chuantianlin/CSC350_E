<?php
include 'connection.php';

//Create a date array
$DATE=array("MON","TUE","WED","THUR","FRI","SAT","SUN");

//get the classroom information and use  mysqli_fetch_array functon to store it
     $SQL_Classroom="SELECT * FROM class_room";
     $ROOM_NUM=mysqli_query($conn, $SQL_Classroom);
     $CLASSROOM=array();
     $ROOM_INDEX=0;
     $Number_of_rooms=0;
     while($ROOM= mysqli_fetch_array($ROOM_NUM,MYSQLI_NUM))
     {
          $CLASSROOM[$ROOM_INDEX]=$ROOM[0];
          $ROOM_INDEX++;
          $Number_of_rooms++;
     }

    echo'<form action="" method="post">';
    echo'<select name=index>';
    echo'<p><option>Choose an classroom No to check</option>';
           for($ROOM_INDEX=0;$i<$Number_of_rooms;$i++)
             {

              echo '<option value='.$ROOM_INDEX. '>'.$CLASSROOM[$ROOM_INDEX].'</option>';
              $ROOM_INDEX++;

              }
    echo  '</select>
    <input type="submit" name="submit" value="Get Selected Values" />
     </form>';
     echo'  <html>
      <head>
        <title>Schedule</title>
        <link rel="stylesheet" href="sample.css">
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
            </tr> ';

    if(isset($_POST['submit'])){
     $ROOM_INDEX = $_POST['index'];




         $SQL="SELECT the_date,classroom,section,starttime,endtime FROM class_arrangement.class_schedule
        where classroom='".$CLASSROOM[$ROOM_INDEX]."' order  by classroom,CASE

        WHEN the_Date = 'Mon' THEN 0
        WHEN the_Date = 'Tue' THEN 1
        WHEN the_Date= 'Wed' THEN 2
        WHEN the_Date = 'Thur' THEN 3
        WHEN the_Date= 'Fri'THEN 4
        WHEN the_Date = 'Sat' THEN 5
        WHEN the_Date = 'Sun' THEN 6
        END, starttime";
        $index=0;
        $size=0;
        $The_Date=array();
        $ROOM=array();
        $section=array();
        $starttime=array();
        $Endtime=array();
        $SQL=mysqli_query($conn, $SQL);
    while($class_Schedule= mysqli_fetch_array($SQL,MYSQLI_NUM))
    {
      $The_Date[$index]=$class_Schedule[0];
      $ROOM[$index]=$class_Schedule[1];
      $section[$index]=$class_Schedule[2];
      $starttime[$index]=$class_Schedule[3];
      $Endtime[$index]=$class_Schedule[4];
      $index++;
      $size++;
      $flag=true;

    }

    $row = 19;
    $col = 7;
    $index=0;
    $time_index=0;
if($size>0)
    {        $time_index=0;
          echo '<tr onmouseover="changeColor(this)" onmouseout="restoreColor(this)">';
          for ($z=1; $z <= $col; $z++)
           {

        echo '<td id="weekdays">';

            while($The_Date[$index]==$DATE[$time_index])
            {


              echo "<p><strong>CLASSROOM:</strong>".$CLASSROOM[$ROOM_INDEX].'</br>'
                 . "<p><strong>SECTION:</strong>".$section[$index].'</br>'.
                   "<p><strong>TIME:</strong>".$starttime[$index]."--".$Endtime[$index]."</br>";
              echo "<hr>";


              if($index==$size-1){break;}
              if($The_Date[$index]==$DATE[$time_index]) $index++;


             }

             $time_index++;

               echo'</td>';


           }

          echo "</tr>";


    }
 else   echo "<script type='text/javascript'>alert('No classes are scheduled in this classroom');</script>";
        // closing connection
       mysqli_close($conn);
}
echo '</body>
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

</html>';
?>
