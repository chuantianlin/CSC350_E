<html>
<head>
<title>csv READER</title>
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
        classes.hoursperweek,class_info.courseNo,class_info.NUm_of_day_to_meet
        from classes
        join  class_info
        on class_info.courseNO=classes.courseNO where NUm_of_day_to_meet>1";
       $A = mysqli_query($conn, $SQL_A);
       $SQL_starttime="SELECT class_schedule.starttime from class_schedule";
       $C=mysqli_query($conn, $SQL_starttime);
       $flag=true;

       //Create a date array
       $DATE=array("MON","TUE","WED","THUR","FRI","SAT","SUN");

       //store classroom Info
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
     $seconds =floor($seconds-$minutes * 60);
     if($minutes==9||$minutes==19||$minutes==29||$minutes==39||$minutes==49||$minutes==59)
     {
       $minutes=$minutes+1;
       if($minutes==60)
       {
         $minutes=0;
         $hours+=1;
       }
       $seconds=0;
     }

return str_pad($hours,2,"0",STR_PAD_LEFT).str_pad($minutes,2,"0",STR_PAD_LEFT).str_pad($seconds,2,"0",STR_PAD_LEFT);
 }


        $ROOM_INDEX=-1;
        $index=0;
        $Flag_2=true;
        $odd=0;
        while($row = mysqli_fetch_array($result,MYSQLI_NUM))
      {
        $time=0;
        $time_index=0;
        $SQL_A = mysqli_fetch_array($A);
        $Houraweek=$SQL_A[0];

        if(!$Flag_2&&$odd%2!=0)
        {$index=1;}
        else
        {
          $index=0;
        }

        if($flag){
                $flag_2=true;
                $starttime=0;
                $start=8;
                $End;
                $E=array(1,2,3,4,5);
                $endtime;
                if($start==8&&$DATE[$index]=="MON"){$ROOM_INDEX++;}
              }

    for($i=$row[0];$i>0;$i--)
       {
              if(!$flag)
           {

             $start=$E[$time]+1/6;

           }
        if($DATE[$index]=="WED"&&$start>=13&&$start<=16)
         {
             $start=16;
         }
        if($SQL_A[0]%$SQL_A[2]==0)
        {$E[$time_index]=$End=$start+$SQL_A[0]/$SQL_A[2];
         $time_index++;

        }
        else
        {   if($Houraweek%$i!=0&&$i!=1)
            {$duration=$Houraweek-$i;}
            else
            {
              $duration=$Houraweek;
            }
            $End=$start+$duration;
            $E[$time_index]=$End;
            $time_index++;
            $Houraweek=$Houraweek-$duration;

        }

        $starttime=convertTime($start);
        $endtime=convertTime($End);
        $section=$SQL_A[1]."-".$starttime;

          $SQL="INSERT into class_schedule(starttime,endtime,CourseNo,THE_DATE,classroom,Section)
          values('$starttime','$endtime','$SQL_A[1]','$DATE[$index]','$CLASSROOM[$ROOM_INDEX]','$section')";
           if($index<6)
           {$index+=2;}
          $B = mysqli_query($conn, $SQL);
          $time++;

           if($End>20)
           {
                break;
           }
      }

                   $flag=False;
                   if($End>20)
                   {

                     $flag=true;
                     $Flag_2=false;
                     $odd++;

                   }

    }
}
?>
</body>
</html>

