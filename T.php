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
     echo '<html>
      <head>
        <title>Schedule</title>
        <link rel="stylesheet" href="table.css">
    <link href="https://fonts.googleapis.com/css?family=Calligraffitti" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Cantarell">

      </head>
      <body>
      <div class="ReturnToTable">
      <a href="getcss.php">
      
    <IMG SRC="arrow.gif"height="50" width="100" class="arrow">
  </a>
      ';

    echo' <form action="" method="post">';
    echo'<select name=index required>';
    echo"<p><option value=''>Clssroom</option>";
           for($ROOM_INDEX=0;$i<$Number_of_rooms;$i++)
             {

              echo '<option value='.$ROOM_INDEX. '>'.$CLASSROOM[$ROOM_INDEX].'</option>';
              $ROOM_INDEX++;

              }
    echo  '</select>
    <input type="submit" name="submit" value="Get Selected Values " />
     </form>';
     echo' <table border="">
          <tr class="weekdays">
            <th>Monday</th>
            <th>Tuesday</th>
            <th>Wenesday</th>
            <th>Thursday</th>
            <th>Friday</th>
            <th>Saturday</th>
            <th>Sunday</th>
            </tr> ';

    if(isset($_POST['submit'])){
     $ROOM_INDEX = $_POST['index'];



        //Get all the class schedule by the order
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
        // get the maximu of schedule classes in specific date
        $M="SELECT count(section) FROM class_arrangement.class_schedule
       where classroom='".$CLASSROOM[$ROOM_INDEX]."' group by the_date order  by count(section) desc,classroom,CASE
       WHEN the_Date = 'Mon' THEN 0
       WHEN the_Date = 'Tue' THEN 1
       WHEN the_Date= 'Wed' THEN 2
       WHEN the_Date = 'Thur' THEN 3
       WHEN the_Date= 'Fri'THEN 4
       WHEN the_Date = 'Sat' THEN 5
       WHEN the_Date = 'Sun' THEN 6
       END, starttime";
       $Max=mysqli_query($conn, $M);
       $Maximum=array();
       if($Max= mysqli_fetch_array($Max,MYSQLI_NUM))
       {
          $Maximum[0]=$Max[0];
        }

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

    $col = 7;
    $index=0;
    $time_index=0;
if($size>0)
    {        $time_index=0;
          echo '<tr id="row">';
          for ($z=1; $z <= $col; $z++)
           {

        echo '<td id="schedule">';
             for($i=0;$i<$Maximum[0];$i++)
          {
             if($The_Date[$index]==$DATE[$time_index])

             {


              echo "<strong><p>CLASSROOM:</strong>".$CLASSROOM[$ROOM_INDEX]
                 . "<strong><p>SECTION:</strong><br>".$section[$index].
                   "<strong><p>TIME:</strong><br>".$starttime[$index]."--".$Endtime[$index];
            echo '<hr class="rounded">';
              if($index==$size-1){$index=0;}

                  $index++;
             }
              else
              {
                echo "<p><br>";
                echo "<p><br>";
                echo "<p><br>";
                echo "<p><br>";
                echo '<hr class="rounded">';

              }
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
echo '
</table>
 </body>
</html>';
?>
