
<html>
<head>
<title>CVS READER</title>
<link rel="stylesheet" href="style.css">
<script src="https://phppot.com/wp-content/uploads/2018/02/csv-to-database.jpg"></script>
</head>
<body>
  <h1>Schedule Program</h1>
  <form class="form-horizontal" action="" method="post" name="uploadCSV"
      enctype="multipart/form-data">
      <div class="input-row">
          <label class="inputTitle">Courses CSV File:</label>
          <input type="file" name="file" id="fInput" accept=".csv">
            </br>
          <label class="inputTitle">Rooms CSV File:</label>
          <input type="file" name="Rfile"  id="sInput" accept=".csv">
                </br>
          <button id="b" type="submit" name="import">Import</button>
          <br />
      </div>
      <div id="labelError"></div>
  </form>

<?php
$conn = mysqli_connect("localhost", "root", "", "class_arrangement");


if (isset($_POST["import"])) {
  //echo"hello";

    $fileName = $_FILES["file"]["tmp_name"];


    if ($_FILES["file"]["size"] > 0) {


        $myQ="Delete from course_Info";
        $result = mysqli_query($conn, $myQ);

        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into course_Info
                   values ('" . $column[0] . "','" . $column[1] . "')";
            $result = mysqli_query($conn, $sqlInsert);


        }
    }

      $handle = $_FILES["Rfile"]["tmp_name"];
    if ($_FILES["Rfile"]["size"] > 0) {

        //  echo"HI";
        $myQ="Delete from roomnum";
        $esult = mysqli_query($conn, $myQ);

        $file = fopen($handle, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into roomnum
                   values ('" . $column[0] . "')";
            $result = mysqli_query($conn, $sqlInsert);


        }
      }
}
?>
</body>
</html>
