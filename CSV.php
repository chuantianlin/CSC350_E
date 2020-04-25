<html>
<head>
<title>csv READER</title>
</head>
<body>
  <form class="form-horizontal" action="csv.php" method="post" name="uploadCSV"
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


       $SQL="SELECT NUm_of_day_to_meet from class_info /*where NUm_of_day_to_meet>1*/ order by NUm_of_day_to_meet desc";
       $result = mysqli_query($conn, $SQL);
        $SQL_A=
        "SELECT
        classes.hoursperweek,class_info.courseNo,class_info.NUm_of_day_to_meet
        from classes
        join  class_info
        on class_info.courseNO=classes.courseNO /*where NUm_of_day_to_meet>1*/ order by NUm_of_day_to_meet desc";
       $A = mysqli_query($conn, $SQL_A);

       //Create a date array
       $DATE=array("MON","TUE","WED","THUR","FRI","SAT","SUN");

       //store classroom Info
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

   function decimal($time)
 {

 $time=intval($time[0])*10+intval($time[1])+(intval($time[3])*10+intval($time[4]))/60;

   return $time;
 }
        $flag=true;
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
        if($Flag_2)
        { if($odd%2!=0)
          $index=1;
          else
          $index=0;
       }
        if($flag){
            if($ROOM_INDEX==$Number_of_rooms-1)
            {
            $Flag_2=false;
            $index=6;
            $ROOM_INDEX=0;
            }
                $starttime=0;
                $start=8;
                $End;
                $E=array(0,0,0,0,0,0,0);
                $endtime;
                if($start==8&&$DATE[$index]=="MON")
                {
                  $ROOM_INDEX++;
                }

              }

    for($i=$row[0];$i>0;$i--)
       {
         if($row[0]==1)
         {
           $time=$index;
           $time_index=$index;
         }
              if(!$flag&&$DATE[$index]!="SUN")
           {

             $start=$E[$time]+1/6;/* update the start time of each classadd 1/6(it is 1/6 hour which is ten minuytes)*/
          }




          if($DATE[$index]=="WED"&&$start>=13&&$start<=16)
           {
               $start=16;// save for the club time (2PM-4PM)
           }
        if($SQL_A[0]%$SQL_A[2]==0)
        {
          if($DATE[$index]=="WED")
           {
              if($start+$SQL_A[0]/$SQL_A[2]>14)
               $start=16;
           }
         $E[$time_index]=$End=$start+$SQL_A[0]/$SQL_A[2];
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

          $SQL_insert="INSERT into class_schedule(starttime,endtime,CourseNo,THE_DATE,classroom,Section)
          values('$starttime','$endtime','$SQL_A[1]','$DATE[$index]','$CLASSROOM[$ROOM_INDEX]','$section')";
                if ($index<5)
                  {$index+=2;}
            mysqli_query($conn, $SQL_insert);
               $time++;

               if($DATE[$index]=="SUN")
             {

                $start=$End+1/6;

            }
           if($End>=19.5)//if the end time is later than 8pm then jump out the loop
            {
                break;
            }

      }
                   $flag=False;
                   if($End>=19.5)
                   {
                     $flag=true;
                     $odd++;
                     if($index==6)
                     {$ROOM_INDEX++;}
                   }

          }

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


          $SQL_onedaysection="SELECT classroom, max(ENDTIME),the_date FROM class_schedule
          where the_date in(select the_date from class_schedule) group by
          the_date,classroom having max(ENDTIME)<173000";
          $SQL_onedaysection=mysqli_query($conn, $SQL_onedaysection);
          $index=0;
          $size=0;
          $E_OS=array("0");
          $CLASSROOM_OS=array("0");
          $DATE_OS=array("0");
          while($ONEDAYSECTION= mysqli_fetch_array($SQL_onedaysection,MYSQLI_NUM))
          {
              $CLASSROOM_OS[$index]=$ONEDAYSECTION[0];
              $E_OS[$index]=decimal($ONEDAYSECTION[1]);
              $DATE_OS[$index]=$ONEDAYSECTION[2];
              $index++;
              $size++;


          }


  $SQL_A=
  "SELECT
  classes.hoursperweek,class_info.courseNo
  from classes
  join  class_info
  on class_info.courseNO=classes.courseNO where NUm_of_day_to_meet=1";
  $A = mysqli_query($conn, $SQL_A);
  $index=0;
  $ROOM_INDEX=0;
  $flag=true;
  $time_index=0;
  $CLASSROOM=array("F12","F13","F14","F12","F13","F14","F12","F13","F14");
/*  while($row = mysqli_fetch_array($A,MYSQLI_NUM))
  {

    if($flag)
            {
             $start=$E_OS[$index];
            }
            if($DATE_OS[$index]=="WED")
             {
                if($End>14)
                 $start=16;
             }
       $End=$start+$row[0];
       $starttime=convertTime($start);
       $endtime=convertTime($End);
       $section=$row[1]."-".$starttime;
       $SQL_insert="INSERT into class_schedule(starttime,endtime,CourseNo,THE_DATE,classroom,Section)
       values('$starttime','$endtime','$row[1]','$DATE_OS[$index]','$CLASSROOM_OS[$ROOM_INDEX]','$section')";
        $B=mysqli_query($conn, $SQL_insert);
       //if($B){echo "Wrong"; }
       if(!$flag){$start=$End+1/6;}

       if($time_index<$size-1)
         {
             if($time_index<9);
          {
              $CLASSROOM_OS[$ROOM_INDEX]=$CLASSROOM[$ROOM_INDEX];
          }
           $index++;
           $ROOM_INDEX++;
           $time_index++;

       }
       else
        {
          $index=6;
          $DATE_OS[6]="SUN";
          echo $DATE_OS[6];
          if($flag)
          {
            $ROOM_INDEX=0;
            $start=8;
            $End=0;
          }
          $flag=false;

       }
       if(!$flag&&$End>17.5)
       {
          $start=8;
         $ROOM_INDEX++;
         if($ROOM_INDEX==$Number_of_rooms)
          {break;}
       }

  }*/
}





?>
</body>
</html>
