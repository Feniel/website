<?php
    include_once '../includes/functions.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LeNerds</title>
    <!-- Bootstrap imports -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel= "stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap‐theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Custom Imports -->
    <link rel="stylesheet" type="text/css" href="../sheets/outer.css"/>
    <link rel="icon" href="media/favicon.png"/>
</head>
<body>
<div id="nav">
    <div id="left">
        <img src="../media/NavIcon.png" alt="Logo" />
    </div>
    <div id="right">
        <a href="../index.php"><img src="../media/hButton.png" alt="" /></a>
    </div>
</div>
<div id="media">
    <?php
        $n = getId();
        $i = 0;

        while($n > $i){
            echo '<a href=""><img src="../media/thumb/med"+$i+".jpg"></a>';
            $i++;
        }
    ?>
</div>
</body>
</html>