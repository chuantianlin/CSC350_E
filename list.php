
<?php

echo
'<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Boogaloo" rel="stylesheet">
<style>
html{
  overflow-x: hidden;
}
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;

  padding: 10px;
  height:40px;
width:100%;
}
body{
    background-color: #d9e8f0;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
/* Style the buttons */
.btn {
  margin-top:-30px;
  border: none;
  outline: none;
  padding: 12px 16px;
  background-color: #f1f1f1;
  cursor: pointer;
}

.btn:hover {
  background-color: #ddd;
}

.btn.active {
  background-color: #666;
  color: white;
}'.
"p.b {
word-spacing: 135px;
font-family:'Boogaloo';
font-size:22px;
display: table-cell;



}
p.a {
  word-spacing: 170px;
font-family:'Boogaloo';
font-size:20px;
display:table-cell;
vertical-align:top;
border:2px solid;
border-style:hidden;
padding-left:125px;




}
p.d {
  word-spacing: 80px;
font-family:'Boogaloo';
font-size:20px;
display:table-cell;
vertical-align:top;

}
p.e{
  word-spacing: 75px;
font-family:'Boogaloo';
font-size:20px;
display:table-cell;
vertical-align:top;

}
</style>
</head>
<body>".
'<a href="T.php">
  <IMG SRC="arrow.gif"height="50" width="100" class="arrow">
</a>
<p>Click on a button to list all classes list by different orders.</p>';
echo '<div id="btnContainer">
  <form action="list.php" method="post">
  <button type="submit" class="btn"    name="the_date"  ><i class="fa fa-th-large">DATE</i></butto>
  <button type="submit" class="btn"    name="section"   ><i class="fa fa-bars"> SECTION</i></butto>
  <button type="submit"  class="btn"   name="courseNO"  ><i class="fa fa-th-large">COURSE NO</i></butto>
  <button type="submit" class="btn"   name="CLASSROOM"><i class="fa fa-th-large">ROOM</i></butto>
  </form>';
echo'</div>
<br>';
$order="";

if(isset($_POST['section'])){$order="section";}
if(isset($_POST['courseNO'])){$order="courseno";}
if(isset($_POST['the_date'])){$order="The_date";}
if(isset($_POST['CLASSROOM'])){$order="CLASSROOM";}
include 'connection.php';
if($order!="")
{
function decimal($time)
{

$time=intval($time[0])*10+intval($time[1])+(intval($time[3])*10+intval($time[4]))/60;

return $time;
}

$SQL="SELECT section,courseno,the_date,classroom,starttime,endtime FROM class_arrangement.class_schedule
 order  by ". $order;
 if($order=="The_date")
 $SQL="SELECT section,courseno,the_date,classroom,starttime,endtime FROM class_arrangement.class_schedule
order  by CASE
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
$CLASSROOM=array();
$The_Date=array();
$ROOM=array();
$COURSENO=array();
$section=array();
$starttime=array();
$Endtime=array();
$SQL=mysqli_query($conn, $SQL);
if($SQL)
{while($class_Schedule= mysqli_fetch_array($SQL,MYSQLI_NUM))
{

$section[$index]=$class_Schedule[0];
$COURSENO[$index]=$class_Schedule[1];
$The_Date[$index]=$class_Schedule[2];
$The_Date[$index]=substr($The_Date[$index],0,2).".";
$CLASSROOM[$index]=$class_Schedule[3];
if(decimal($class_Schedule[4])<=12)
$starttime[$index]=$class_Schedule[4]."am";
else
$starttime[$index]=$class_Schedule[4]."pm";
if(decimal($class_Schedule[4])<=12)
$Endtime[$index]=$class_Schedule[5]."am";
else
$Endtime[$index]=$class_Schedule[5]."pm";
$index++;
$size++;
}

$index=0;
for($i=0;$i<$size-1;$i++)
{
  if($i==0)
    echo '<div class="row">
    <div class="column" style="background-color:green;">
     <p class="d">'."SECTION_NUMBER."."&nbsp".
      "COURSE_NUMBER."."&nbsp".
      "DATE".'&nbsp'."CLASSROOM".'</p>'.'<p class="e">'."&nbsp&nbsp"."STATRTTIME"
      ."&nbsp&nbsp".
      "ENDTIME".'</p></div>';
echo '<div class="row">
  <div class="column" style="background-color:#B2C8A6;">
   <p class="b">'.$section[$index]."&nbsp".
    $COURSENO[$index]."&nbsp".
    $The_Date[$index].'</p>'.'<p class="a">'.$CLASSROOM[$index]."&nbsp".
    $starttime[$index]."&nbsp".
    $Endtime[$index].'</p></div>';
    $index++;
    if($index==$size-1)break;
  echo'<div class="column" style="background-color:green;">
  <p class="b">'.$section[$index]."&nbsp".
   $COURSENO[$index]."&nbsp".
   $The_Date[$index].'</p>'.'<p class="a">'.$CLASSROOM[$index]."&nbsp".
   $starttime[$index]."&nbsp".
   $Endtime[$index].'</p>'.'</div>';
   $index++;
   if($index==$size-1)break;

}

}

echo'<script>
</body>
</html>';
}
?>
