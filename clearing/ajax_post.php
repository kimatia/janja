<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'dbconfig.php';

$BOL = "BOL";
$IDF = "IDF";
$KBS = "KBS";
$ECert = "ECert";
$Invoice = "Invoice";
$TReciept = "TReciept";
$Quadruplicate = "Quadruplicate";
$LBook = "LBook";

if($_SESSION['file']==$BOL){

  if(isset($_FILES["file"]["type"]) && isset($_POST['billofLadingNumber']))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $billofLadingNumber = $_POST['billofLadingNumber'];

  $_SESSION['bol'] = $billofLadingNumber;

  $stackNumber = $_POST['stackNumber'];
  $shippername = $_POST['shippername'];
  $shipperadress  = $_POST['shipperadress'];
  $shipperlocation = $_POST['shipperlocation'];
  $consigneename = $_POST['consigneename'];
  $consigneeadress = $_POST['consigneeadress'];
  $consigneelocation = $_POST['consigneelocation'];
  $precariageBy = $_POST['precariageBy'];
  $placeofReciept = $_POST['placeofReciept'];
  $vessel  = $_POST['vessel'];
  $voyno  = $_POST['voyno'];
  $loadingport  = $_POST['loadingport'];
  $dischargeport = $_POST['dischargeport'];
  $finalDestination = $_POST['finalDestination'];
  $freightName = $_POST['freightName'];
  $revenueTons  = $_POST['revenueTons'];
  $rate = $_POST['rate'];
  $per = $_POST['per'];
  $prepaid  = $_POST['prepaid'];
  $collect  = $_POST['collect'];
  $markNumber = $_POST['markNumber'];
  $description  = $_POST['description'];
  $grossweight  = $_POST['grossweight'];
  $measurement  = $_POST['measurement'];
  $packagesNo  = $_POST['packagesNo'];
  $freightPayable = $_POST['freightPayable'];
  $numberOriginal = $_POST['numberOriginal'];
  $placeOfIssue  = $_POST['placeOfIssue'];
  $dateOfIssue = $_POST['dateOfIssue'];
  $userId = $_POST['userId'];


  $billofLading_file=$_FILES["file"]["name"];
  $SQL = $con->prepare("INSERT INTO tbl_billofLading(stackNumber, billofLadingNumber, shippername ,shipperadress ,shipperlocation ,consigneename ,consigneeadress ,consigneelocation,precariageBy,placeofReciept,vessel,voyno,loadingport,dischargeport,finalDestination, freightName,revenueTons,rate,per,prepaid,collect,markNumber,description,grossweight,measurement,packagesNo,freightPayable,numberOriginal,placeOfIssue,dateOfIssue ,billofLading_file, userId, postTime ) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,now())");


    if(!$SQL)
    {
     echo $con->error;
   }else{
     $SQL->bind_param('ssssssssssssssssssssssssssssssss',$stackNumber,$billofLadingNumber,$shippername ,$shipperadress  ,$shipperlocation ,$consigneename ,$consigneeadress ,$consigneelocation ,$precariageBy,$placeofReciept,$vessel,$voyno,$loadingport,$dischargeport,$finalDestination, $freightName, $revenueTons,$rate,$per,$prepaid,$collect,$markNumber,$description,$grossweight,$measurement,$packagesNo,$freightPayable,$numberOriginal,$placeOfIssue,$dateOfIssue ,$billofLading_file,$userId);
     $SQL->execute();

     if(!$SQL)
     {
      echo $con->error;
      echo "<div class='alert alert-danger'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Sorry!</strong>Posting failed. This file is post previously
               </div>";
    }else{
      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
        $positive = "Yes";

        $sql = $con->prepare("UPDATE tbl_stacks SET bol=? WHERE stackNumber=?");
        $sql->bind_param("ss",$positive,$stackNumber);
        $sql->execute();
        if(!$sql)
        {
         echo $con->error;
        }

        $file = "bol";

        $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


            $SQL->bind_param('iss',$userId,$stackNumber,$file);
            $SQL->execute();
            if(!$SQL){
              echo $con->error;
            }

      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
              header("refresh:5;addFile.php");
    }
   }
  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
        <button class='close' data-dismiss='alert'>&times;</button>
        <strong>Sorry!</strong>Invalid file Size or Type
        </div>";
  }
  }

}elseif($_SESSION['file']==$IDF){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $idfNumber = $_POST['idfNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $idf_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_idf(stackNumber,idfNo, idf_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$idfNumber, $idf_file, $userId);
      $SQL->execute();

      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET idf=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "idf";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }
      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['file']==$KBS){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $kbsNumber = $_POST['kbsNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $kbs_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_kbs(stackNumber,kbsNo, kbs_file,userId, postTime) VALUES(?,?,?,?,now())");

    if(!$SQL){
       echo $con->error;
    }else{
      $SQL->bind_param('sssi',$stackNumber,$kbsNumber, $kbs_file, $userId);
      $SQL->execute();

      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET kbs=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();

      $file = "kbs";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      if(!$sql)
      {
       echo $con->error;
      }


      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";

    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['file']==$ECert){

  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $ecertNumber = $_POST['ecertNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $ecert_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_ecert(stackNumber,ecertNo, ecert_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$ecertNumber, $ecert_file, $userId);
      $SQL->execute();

      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET ecert=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "ecert";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['file']==$Invoice){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $invoiceNumber = $_POST['invoiceNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $invoice_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_invoice(stackNumber,invoiceNo, invoice_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$invoiceNumber, $invoice_file, $userId);
      $SQL->execute();


      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET invoice=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "invoice";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }


}elseif($_SESSION['file']==$TReciept){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $trecieptNumber = $_POST['trecieptNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $treciept_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_treciept(stackNumber,trecieptNo, treciept_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$trecieptNumber, $treciept_file, $userId);
      $SQL->execute();

      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET treciept=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }

      $file = "treciept";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['file']==$Quadruplicate){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $quadruplicateNumber = $_POST['quadruplicateNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $quadruplicate_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_quadruplicate(stackNumber,quadruplicateNo, quadruplicate_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$quadruplicateNumber, $quadruplicate_file, $userId);
      $SQL->execute();


      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET quadruplicate=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "quadruplicate";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
              <button class='close' data-dismiss='alert'>&times;</button>
              <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }

}elseif($_SESSION['file']==$LBook){


  if(isset($_FILES["file"]["type"]))
  {
  $validextensions = array("jpeg", "jpg", "png", "JPEG", "JPG", "PNG");
  $temporary = explode(".", $_FILES["file"]["name"]);
  $file_extension = end($temporary);
  if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/JPG") || ($_FILES["file"]["type"] == "image/jpeg")
  ) && ($_FILES["file"]["size"] < 10000000)//Approx. 100000=100kb files can be uploaded.
  && in_array($file_extension, $validextensions)) {
  if ($_FILES["file"]["error"] > 0)
  {
  echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
  }
  else
  {
  $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
  $targetPath = "upload/".$_FILES['file']['name']; // Target path where file is to be stored

  $lbookNumber = $_POST['lbookNumber'];
  $stackNumber = $_POST['stackNumber'];
  $userId = $_POST['userId'];
  $lbook_file=$_FILES["file"]["name"];

  $SQL = $con->prepare("INSERT INTO tbl_lbook(stackNumber,lbookNo, lbook_file,userId, postTime) VALUES(?,?,?,?,now())");

    if($SQL){
      $SQL->bind_param('sssi',$stackNumber,$lbookNumber, $lbook_file, $userId);
      $SQL->execute();


      $positive = "Yes";
      $sql = $con->prepare("UPDATE tbl_stacks SET lbook=? WHERE stackNumber=?");
      $sql->bind_param("ss",$positive,$stackNumber);
      $sql->execute();
      if(!$sql)
      {
       echo $con->error;
      }


      $file = "lbook";

      $SQL = $con->prepare("INSERT INTO tbl_logs(userId,stackNumber,file, postTime) VALUES(?,?,?,now())");


          $SQL->bind_param('iss',$userId,$stackNumber,$file);
          $SQL->execute();
          if(!$SQL){
            echo $con->error;
          }

      move_uploaded_file($sourcePath,$targetPath) ; // Moving Uploaded file
      echo "<div class='alert alert-success'>
            <button class='close' data-dismiss='alert'>&times;</button>
            <strong>Success!</strong>.File Uploaded</div>";
    }else{
      echo $con->error;
    }

  }
  }
  else
  {
  echo "<div class='alert alert-danger'>
          <button class='close' data-dismiss='alert'>&times;</button>
          <strong>Sorry!</strong>Invalid file Size or Type
           </div>";
  }
  }
}



?>
