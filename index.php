<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LeNerds</title>
    <!-- Bootstrap import -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Custom Import -->
    <link rel="stylesheet" type="text/css" href="sheets/outer.css"/>
    <link rel="icon" href="media/favicon.png"/>
    <script type="text/JavaScript" src="js/sha512.js"></script>
    <script type="text/JavaScript" src="js/forms.js"></script>
</head>
<body>
<div id="nav">
    <div id="left">
        <img src="media/NavIcon.png" alt="Logo" />
    </div>
    <div id="right">
        <a href="sites/media.php"><img src="media/hButton.png" alt="Button"></a>
    </div>
</div>
<div id="login">
    <h4>Herzlich Willkommen</h4>
    <form action="includes/process_login.php" method="post" name="login_form">
        <input type="text" name="email" id="email" class="form-control input-sm chat-input" placeholder="username" />
        </br>
        <input type="password" name="password" id="password" class="form-control input-sm chat-input" placeholder="password" />
        </br>
        <input type="submit" name="login" class="btn btn-primary btn-md" value="Login" onclick="formhash(this.form, this.form.password);">
        <?php
        if (isset($_GET['error'])){
            echo '<span id="error">Error Logging In!<span>';
        }
        ?>
    </form>
</div>
</body>
</html>