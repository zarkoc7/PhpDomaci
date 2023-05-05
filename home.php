<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
require "broker.php";
require "model/user.php";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oglasi</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="https://www.dafontfree.net/embed/c3BlY2lmeS1wZXJzb25hbC1ub3JtYWwtYmxhY2smZGF0YS81Mi9zLzE1Njg5Ny9TcGVjaWZ5UEVSU09OQUwtTm9ybUJsYWNrLnR0Zg" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/oglas.css?v=2" type="text/css">

</head>

<body>
    
    <nav>
        <a href="home.php" class="logo">Ananas</a>
       <div class="currentlyLogged"> 
            <span class="loggedIn">Trenutno je ulogovan:</span>
            <span class="loggedIn">
            <?php echo $_SESSION["user_name"]; ?>
            </span>
        </div>
       
       
        <div> <a class="btn btn-danger" href="logout.php">Odjavi se</a></div>
       
    </nav>

    <div class="background-wrapper">

    </div>
    <div class="container">
        <div class="row centerClass">
            <div class="col-md-6 textCenter">
                <div id="pretraga" class="d-flex justify-content-center">
                    <div class="content d-flex flex-column">
                        <form action="">
                            <label for="fname">Pretrazi po naslovu:</label>
                            <input type="text" id="fname" class="inputForma" name="fname" onkeyup="showHint(this.value)">
                        </form>
                        <p><span id="txtHintt"></span></p>
                    </div>
                </div>

            </div>
        </div>

        <div class="row centerClass">
            <div class="col-md-9">
                <div class="row d-flex justify-content-center">
                    <div class="d-flex flex-column">
                        <form>
                            <select  class="selectMeni" name="users"  onchange="showUser(this.value)">
                                <option value="">Selektuj korisnika:</option>
                                <option value="1">Admin</option>
                                <option value="2">Zarko</option>
                            </select>
                        </form>
                        <br>
                        <div id="txtHint"><b></b></div>
                    </div>
                    <div id="dodavanje" class="col-md-5">
                        <div class="card card-body">
                            <form action="kontroler/add.php" id="dodajForm" name="unosOglasa" onsubmit="return validateForm()" method="POST">

                                <div class="form-group">
                                    <input type="text" name="naslov" class="form-control inputForma" placeholder="Naslov" autofocus>
                                </div>

                                <div class="form-group">
                                    <textarea name="opis" rows="5" class="form-control inputForma" placeholder="Opis"></textarea>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="cena" class="form-control inputForma" placeholder="Cena">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="pregledi" class="form-control inputForma" placeholder="Pregledi">
                                </div>


                                <input type="submit"  name="add" class="btn btn-primary btn-block dugme" value="Sacuvaj oglas">

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row centerClass">
            <div class="col-md-9 mt-5">
                <table id="tabelaOglasi" class="table">
                    <thead>
                    <tr>
                        <th >Naslov</th>
                        <th>Opis</th>
                        <th >Cena</th>
                        <th>Pregledi</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $query = "SELECT * FROM oglas";
                    $oglasi = mysqli_query($conn,$query);
                    // $oglasi = $conn->query($query);
                   
                    while ($row = mysqli_fetch_array($oglasi)) { 
                        $id=$row['oglasID'];
                        $naslov=$row['naslov'];
                        $cena=$row['cena'];
                        $opis=$row['opis'];
                        $pregledi=$row['pregledi'];
                       
                        ?>
                        <tr>
                            <td><?=$naslov ?></td>
                            <td><?=$opis ?></td>
                            <td><?=$cena ?></td>                           
                            <td><?=$pregledi ?></td>
                            <td>
                                <a href="kontroler/edit.php?id=<?php echo $row['oglasID'] ?>" class="izmeni">Izmeni</a>  
                                <span class="delete" id='del_<?=$id?>'> Obrisi </span>
                            </td>
                            
                        </tr>
                        
                    <?php  } ?>
                    </tbody>
                </table>
            </div>
        </div>




    </div> 
    <script>
            $(document).ready(function(){
            $('.delete').click(function(){
            var el = this;
            var id=this.id;
            var splitid= id.split('_');
            var deleteid= splitid[1];
            var confirmalert = confirm("Da li ste sigurni?");
            if (confirmalert == true) {
                        $.ajax({
                        url: 'kontroler/remove.php',
                        type: 'post',
                        data: { id:deleteid },
                        success: function(response){

                            if(response == 1){
                        
                        $(el).closest('tr').css('background','red');
                        $(el).closest('tr').fadeOut(600,function(){
                            $(this).remove();
                        });
                }else{
            alert('Invalid ID.');
                }

            }
            });
            }

            });

            });



        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "getuser.php?q=" + str, true);
                xmlhttp.send();
            }
        }

        function showHint(str) {
            if (str.length == 0) {
                document.getElementById("txtHintt").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHintt").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "gethint.php?q=" + str, true);
                xmlhttp.send();
            }
        }
    </script>



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    
    <script>
        $('#tabelaOglasi th').click(function(){
            var table = $(this).parents('table').eq(0)
            var rows = table.find('tr:gt(0)').toArray().sort(comparer($(this).index()))
            this.asc = !this.asc
            if (!this.asc){rows = rows.reverse()}
            for (var i = 0; i < rows.length; i++){table.append(rows[i])}
        })
        function comparer(index) {
            return function(a, b) {
                var valA = getCellValue(a, index), valB = getCellValue(b, index)
                return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.toString().localeCompare(valB)
            }
        }
        function getCellValue(row, index){ return $(row).children('td').eq(index).text() }
    </script>

    
</body>

</html>


