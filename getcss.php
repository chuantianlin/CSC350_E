<html>
<head>
<title>CVS READER</title>
<link rel="stylesheet" href="page.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Sofia">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
  <a href="list.php">
<IMG SRC="arrow.gif"height="50" width="100" class="arrow">
</a>


  <div class="intro">
    <h1 id="firstWord">Schedule </h1>
    <h1 id="secondWord">Program</h1>

  <form class="form-horizontal" action="" method="post" name="uploadCSV"
      enctype="multipart/form-data">
      <div class="input-row">
      <label class="inputTitle">Courses CSV File:</label><spaon>
      <div id="div1" class="fa"></div>
      <input type="file" name="file" id="fImput" accept=".csv" required>
      </br>
      <label class="inputTitle">Rooms CSV File:</label>
      <div id="div2" class="fa"></div>
      <input type="file" name="Rfile"  id="sImput" accept=".csv" required>
        </br>
        <button id="submit" type="submit" name="UPLOAD" class="button">UPLOAD</button>
      </div>
      </br>
    </form>
    </div>
    <script>
    function openfolder()
    {
       var a;
       var b;
      a = document.getElementById("div1");
      b = document.getElementById("div2");
      a.innerHTML = "&#xf114;";
      b.innerHTML = "&#xf114;";
      setTimeout(function ()
      {
          a.innerHTML = "&#xf115;";
          b.innerHTML = "&#xf115;";
      }, 1000);
    }
    openfolder();
    setInterval(openfolder, 2000);
    </script>
<?php

include 'connection.php';

if (isset($_POST["UPLOAD"])) {    /* import data from CSV file*/


    $fileName = $_FILES["file"]["tmp_name"];


    if ($_FILES["file"]["size"] > 0) {


        $myQ="Delete from class_info";
        $result = mysqli_query($conn, $myQ);

        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
          if(isset($column['1']))
        {
            $sqlInsert = "INSERT into class_info
                   values ('" . $column[0] . "','" . $column[1] . "')";

            $result = mysqli_query($conn, $sqlInsert);
          }
        else
        {
          echo "<script type='text/javascript'>alert('Something wrong with file format... Please try again');</script>";
          exit();

        }


        }

    }

    $handle = $_FILES["Rfile"]["tmp_name"];
    if ($_FILES["Rfile"]["size"] > 0) {


        $myQ="Delete from class_room";
        $esult = mysqli_query($conn, $myQ);

        $file = fopen($handle, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into class_room
                   values ('" . $column[0] . "')";
            $result = mysqli_query($conn, $sqlInsert);


        }
      }     //   all above is to import data from csv file

      $myQ="Delete from class_schedule";
      $esult = mysqli_query($conn, $myQ);


     // varify the input
      $index=0;
      $size=0;
      $VALID=true;
      $COURSEINFO=array();
      $SQL="SELECT * from class_Info";
      $courseInfo = mysqli_query($conn, $SQL);
    while($cInfo= mysqli_fetch_array($courseInfo,MYSQLI_NUM))
      {

         $COURSEINFO[$index]=$cInfo[0];
         $index++;

         if($cInfo[1]<=0)
         {
           $VALID=false;
          echo "<script type='text/javascript'>alert('Invalid  number of days to meet on row $index');</script>";
          break;

         }

         $size++;

      }
      $index=0;
    $SQL="SELECT  COURSENO from classes";
      $courseInfo = mysqli_query($conn, $SQL);
      while($cInfo= mysqli_fetch_array($courseInfo,MYSQLI_NUM))
      {
         $CisCourse[$index]=$cInfo[0];
          $index++;
      }
        $index=0;
      while($VALID&&$index<$size-1)
      {
        $VALID=in_array($COURSEINFO[$index],$CisCourse);
        $index++;
        if(!$VALID)
        {
          echo "<script type='text/javascript'>alert('No course number on row $index exists on CIS dep');</script>";

           break;
        }
          $index++;

       }

      if($VALID)
     {
         echo "<script type='text/javascript'>alert('Submit succesfully!');</script>";
       // get the course that meet more than one day  and save in array
       $SQL="SELECT NUm_of_day_to_meet from class_info where NUm_of_day_to_meet>1 order by courseno";
       $result = mysqli_query($conn, $SQL);
        $SQL_A=
        "SELECT
        classes.hoursperweek,class_info.courseNo,class_info.NUm_of_day_to_meet
        from classes
        join  class_info
        on class_info.courseNO=classes.courseNO where NUm_of_day_to_meet>1 order by courseno";
       $A = mysqli_query($conn, $SQL_A);

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


//convet decimal hour to time format(18.5-->183000)
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

// Covert time to decimal hour (183000-->18.5)
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
        $s=0;
        $Coursetitle="";
        $Sectiontemp="";
        $break_flag=false;
    // arrange the class that meet more than one day
        while($row = mysqli_fetch_array($result,MYSQLI_NUM))
      {

        $time=0;
        $time_index=0;
        $SQL_A = mysqli_fetch_array($A);// to get each class's weekly hours
        $Houraweek=$SQL_A[0];
        if($Flag_2)
        { if($odd%2!=0)//$odd is to alterate the date
          $index=1; // The date index 1 means Tues,0 means Mon etc
          else      // user required  to arrange class on Monday, wednesday,(Friday) IF MEEET THREE DAYS
          $index=0; // or Tuseday,Thurseday,（SAT）if meet three days
       }


        if($flag){

                $starttime=0;//starttime in HHMMSS fomat
                $start=8;//aussuming each day classes start at 8 am
                $End=0;   // to store end time of each class on same date in deciaml hour format like 18.5
                $E=array(0,0,7.83,0,0,0,0);//to store end time on different days
                $endtime;//Endtime in HHMMSS fomat
                if($start==8&&$DATE[$index]=="MON")//When the first classroom has aleady filled with weekly classes

                {                                 //  then Change to anther room[Monday is the start date to arrange class]
                  $ROOM_INDEX++;
                  if($ROOM_INDEX==$Number_of_rooms) // When the Room that is avalible to arrange has been filled the
                  {                                // classes. The program should be terminate.
                    break;
                  }
                }

              }
       $Coursetitle=$SQL_A[1];
       $s+=1;
    for($i=$row[0];$i>0;--$i)//row[0] store the Number of day of each class in a week
       {

              if(!$flag)//if $flag is true that  means it is the first class on each day
           {           // therefor no need to run this statement

             $start=$E[$time]+1/6;/* update the start time of each classadd 1/6(it is 1/6 hour which is ten minuytes)*/
          }                      //The next class's start time should be the end time of the class on the same classroom


          if($DATE[$index]=="WED")
           {
              if($start+$SQL_A[0]/$SQL_A[2]>14&&$start<16)
               $start=16;
           }

          if($SQL_A[0]%$SQL_A[2]==0)
        {

         $E[$time_index]=$End=$start+$SQL_A[0]/$SQL_A[2];// to arrange duration of each class on each day
         $time_index++;
         }
        else{
         if ($Houraweek%$i!=0&&$i!=1)
            {$duration=$Houraweek-$i;}
            else
            {
              $duration=$Houraweek;
              if($Houraweek%$i==0&&$i!=1)//to arrange duration of each class on each day
              {
                $duration=$Houraweek/2;

              }
            }
            $End=$start+$duration;  //if the class is 5 hours to 3 days it'll divided into 2 1 2
            $E[$time_index]=$End;   //if divided into 2 days then 3 2
            $time_index++;
            $Houraweek=$Houraweek-$duration;
          }



          $starttime=convertTime($start);
          $endtime=convertTime($End);
         if($Coursetitle!=$Sectiontemp){$s=0;}


          if($i==$row[0])
          {


             if($start>10)
             $section=$SQL_A[1]."-".($start*100+$s);
             else
             $section=$SQL_A[1]."-"."0".($start*100+$s);
           }// Section (CSC-1200)
          if($i==1){$Sectiontemp=$SQL_A[1];}
          $SQL_insert="INSERT into class_schedule(meetingId,starttime,endtime,CourseNo,THE_DATE,classroom,Section)
          values('0','$starttime','$endtime','$SQL_A[1]','$DATE[$index]','$CLASSROOM[$ROOM_INDEX]','$section')";
                if ($index<5)
                  {$index+=2;}
            mysqli_query($conn, $SQL_insert);
               $time++;
           if($End>=18)//if the end time is later than 17.30pm then arrange classes on different day
            {
              $break_flag=true;
              if($i==1)
            {
              if($break_flag)
               {break;}
            }
                  // one day sectio Will be arranged after this
            }

      }
                   $flag=False;
                   if($End>=18||$break_flag)
                   {
                     $flag=true;
                     $odd++;
                     $break_flag=false;
                   }


          }

 /* IT IS  to arrange classes that only meet one day it is similar to the code above*/
 /*reason why divide into two parts 1.It is easier to arrange class 2.One day section will be
 distributed to every day. so  people have more choice 3. According to users' requirement,
 one day section usually are arranged at evening class for some
 people need to work and Sun day all day are assigned with one day section class */


          $SQL_onedaysection="SELECT classroom, max(ENDTIME),the_date FROM class_schedule
          where the_date in(select the_date from class_schedule) group by
          the_date,classroom having max(ENDTIME)<=180000";
          $SQL_onedaysection=mysqli_query($conn, $SQL_onedaysection);
          $size=0;
          $timeindex=0;
          $E_OS=array();
          $CLASSROOM_OS=array();
          $DATE_OS=array();
          while($ONEDAYSECTION= mysqli_fetch_array($SQL_onedaysection,MYSQLI_NUM))
          {
              $CLASSROOM_OS[$timeindex]=$ONEDAYSECTION[0];
              $E_OS[$timeindex]=decimal($ONEDAYSECTION[1]);
              $DATE_OS[$timeindex]=$ONEDAYSECTION[2];

              $timeindex++;
              $size++;

          }

        $SQL_A=
        "SELECT
        classes.hoursperweek,class_info.courseNo
        from classes
        join  class_info
        on class_info.courseNO=classes.courseNO where NUm_of_day_to_meet=1 order by courseno";
        $A = mysqli_query($conn, $SQL_A);
        $index=0;
        $ROOM_INDEX=0;
        $flag=true;
        $time_index=0;
        $Flag_2=false;
        $timeindex=0;
        $s='A';
        $Coursetitle=" ";
        $Sectiontemp=" ";
        while($row = mysqli_fetch_array($A,MYSQLI_NUM))
        {
          $Coursetitle=$row[1];
          if($Coursetitle!=$Sectiontemp)
          {
             $s='A';
          }

          if($size>=1||$Flag2)
              { if($flag)
                  {
                   $ROOM_INDEX=array_search($CLASSROOM_OS[$time_index],$CLASSROOM);
                   $start=$E_OS[$time_index]+1/6;
                   $index=array_search($DATE_OS[$time_index],$DATE);
                 }

             $End=$start+$row[0];
             if($DATE[$index]=="WED")
              {
                 if($End>14&&$start<16)
                  $start=16;
              }
             $starttime=convertTime($start);
             $endtime=convertTime($End);
             if($start<10)
             $section=$row[1]."-"."0".($start*10).$s;
             else
              $section=$row[1]."-".floor($start*10).$s;
             $SQL_insert="INSERT into class_schedule(starttime,endtime,CourseNo,THE_DATE,classroom,Section)
             values('$starttime','$endtime','$row[1]','$DATE[$index]','$CLASSROOM[$ROOM_INDEX]','$section')";
              $B=mysqli_query($conn, $SQL_insert);

               }

             if(!$flag){$start=$End+1/6;}
                $timeindex++;
             if($timeindex<$size-1)
               {
                 $time_index++;
               }
             else
              {

                $index=6;
                if($flag)
                {
                  $Flag_2=True;
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
                {
                  echo "<script type='text/javascript'>alert('Schedules are too full');</script>";
                              break;
                }
             }

             if(!$flag&&$time_index>=$size-1)
            {
              if($start!=8)
              $start=$End+1/6;

            }
            $Sectiontemp=$row[1];
            $s++;


        }

}
}
echo'
 <p class="imggif"><IMG SRC="giphy.gif"height="62" width="52"></p>
<spain class="a">Need help?Contact us:
<a href="https://www.facebook.com/chuantian.lin" class="fa fa-facebook"></a>
<a href="mailto:llcttt@gmail.com" class="fa fa-google"></a>
<a href="https://www.instagram.com/null_lct/" class="fa fa-instagram"></a></spain>';
?>
