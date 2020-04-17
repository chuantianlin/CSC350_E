

<html>
<head>
<title>CVS READER</title>
</head>
<body>
  <form class="form-horizontal" action="" method="post" name="uploadCSV"
      enctype="multipart/form-data">
      <div class="input-row">
          <label class="col-md-4 control-label">Choose CSV File</label> <input
              type="file" name="file" id="file" accept=".csv" required>
            </br>
              <label >Choose CSV File roomNO</label> <input
                  type="file" name="Rfile"  accept=".csv" required>
                </br>
              <button type="submit" name="import"
                  >Import</button>

          <br />

      </div>
      <div id="labelError"></div>
  </form>

<?php
$conn = mysqli_connect("localhost", "root", "", "class_arrangement");


if (isset($_POST["import"])) {


    $fileName = $_FILES["file"]["tmp_name"];


    if ($_FILES["file"]["size"] > 0) {


        $myQ="Delete from class_info";
        $result = mysqli_query($conn, $myQ);
echo "YES";
        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into class_info
                   values ('" . $column[0] . "','" . $column[1] . "')";

            $result = mysqli_query($conn, $sqlInsert);


        }

    }

    $handle = $_FILES["Rfile"]["tmp_name"];
    if ($_FILES["Rfile"]["size"] > 0) {


        $myQ="Delete from class_room";
        $esult = mysqli_query($conn, $myQ);
echo "YES";
        $file = fopen($handle, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into class_room
                   values ('" . $column[0] . "')";
            $result = mysqli_query($conn, $sqlInsert);


        }
      }
      $SQL="SELECT NUm_of_day_to_meet from class_info where NUm_of_day_to_meet>1";
      $result = mysqli_query($conn, $SQL);

        $SQL_A=
        "SELECT
        classes.hoursperweek/Num_of_Day_to_meet,class_info.courseNo
        from classes
        join  class_info
        on class_info.courseNO=classes.courseNO where NUm_of_day_to_meet>1";
       $A = mysqli_query($conn, $SQL_A);
       $SQL_starttime="SELECT class_schedule.starttime from class_schedule";
       $C=mysqli_query($conn, $SQL_starttime);
       $flag=true;
       $DATE=array("MON","TUE","WED","THUR","FRI","SAT","SUN");
       $SQL_Classroom="SELECT * FROM class_room";
       $ROOM_NUM=mysqli_query($conn, $SQL_Classroom);
       $CLASSROOM=array();
       $ROOM_INDEX=0;
       while($ROOM= mysqli_fetch_array($ROOM_NUM,MYSQLI_NUM))
       {
            $CLASSROOM[$ROOM_INDEX]=$ROOM[0];

            $ROOM_INDEX++;
       }
      function convertTime($dec)
 {
     // start by converting to seconds
     $seconds = ($dec * 3600);
     // we're given hours, so let's get those the easy way
     $hours = floor($dec);
     // since we've "calculated" hours, let's remove them from the seconds variable
     $seconds -= $hours * 3600;
     // calculate minutes left
     $minutes = floor($seconds / 60);
     // remove those from seconds as well
     $seconds -= $minutes * 60;
     // return the time formatted HH:MM:SSdfa
return str_pad($hours,2,"0",STR_PAD_LEFT).str_pad($minutes,2,"0",STR_PAD_LEFT).str_pad($seconds,2,"0",STR_PAD_LEFT);
 }

        $ROOM_INDEX=-1;
        while($row = mysqli_fetch_array($result,MYSQLI_NUM))
      {

        $index=0;

        $SQL_A = mysqli_fetch_array($A);

              if($flag){
                $starttime=0;
                $start=8;
                $End=0;
                $endtime=0;
                $flag=False;
               }

              $end=$start+$SQL_A[0];
              $starttime=convertTime($start);
              $endtime=convertTime($end);
              if($start==8&&$index%2==0){$ROOM_INDEX++;}
              if($end>=20){
                $index=1;}
                $section=$SQL_A[1]."-".$starttime;
                echo $section;
      do{

          $SQL="INSERT into class_schedule(starttime,endtime,CourseNo,THE_DATE,classroom,Section)
          values('$starttime','$endtime','$SQL_A[1]','$DATE[$index]','$CLASSROOM[$ROOM_INDEX]','$section')";




                  $index+=2;
                  $B = mysqli_query($conn, $SQL);
                  $row[0]--;

         }while($row[0]>0);

                   $start=$end+0.1;

                   if($end>=20)
                   {
                     $flag=true;

                   }


    }
}
?>
</body>
</html>
