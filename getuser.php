<!DOCTYPE html>
<html>

<head>
    <style>
        table {
            background-color: rgba(7, 197, 255, 0.5);
            width: 60%;
            border-collapse: collapse;

        }

        table,
        td,
        th {
            border-radius: 0.6rem;
            padding: 5px;
            color: whitesmoke;
        }

        th {
            text-align: left;
        }
    </style>
</head>

<body>

    <?php

    include("broker.php");

    $q = intval($_GET['q']);

    if (!$conn) {
        die('Could not connect: ' . mysqli_error($conn));
    }

    mysqli_select_db($conn, "ananas");
    $sql = "SELECT * FROM user WHERE userID = '" . $q . "'";
    $result = mysqli_query($conn, $sql);

    echo "<table>
<tr>
<th>UserID</th>
<th>Username</th>
</tr>";
    while ($row = mysqli_fetch_array($result)) {
        echo "<tr>";
        echo "<td>" . $row['userID'] . "</td>";
        echo "<td>" . $row['username'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    mysqli_close($conn);

    ?>
</body>

</html>