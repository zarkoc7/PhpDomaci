<?php 
include "../broker.php";

$id = $_POST['id'];

if($id > 0){

  // da li postoji rekord
  $checkRecord = mysqli_query($conn,"SELECT * FROM oglas WHERE oglasID=".$id);
  $totalrows = mysqli_num_rows($checkRecord);

  if($totalrows > 0){
   
    $query = "DELETE FROM oglas WHERE oglasID=".$id;
    mysqli_query($conn,$query);
    echo 1;
    exit;
  }else{
    echo 0;
    exit;
  }
}

echo 0;
exit;