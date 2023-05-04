<?php
include("broker.php");

$query = "SELECT naslov FROM oglas";
$oglasi = $conn->query($query);

$q = $_REQUEST["q"];

$hint = "";


while ($a = mysqli_fetch_assoc($oglasi)) {
    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach ($a as $name) {
            if (stristr($q, substr($name, 0, $len))) {
                if ($hint === "") {
                    $hint = $name;
                } else {
                    $hint .= ", $name";
                }
            }
        }
    }
}

echo $hint === "" ? "no suggestion" : $hint;
