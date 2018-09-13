<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Git integration</title>
    <style>
    body {
        background: url("mounhouse.jpeg");
        background-repeat: no-repeat;
        background-size: cover;
    }
    h1 {
        color: yellow;
        background-color: red;
        margin:  20px auto;
        display: inline-block;
        text-align: center;
    }
    form {
        border: 2px solid green;
    }

    </style>
</head>
<body>
<?php 

if (empty($_GET['git_message'])) { ?>

    <div class="container">
        <div class="content">
            <h1>Say Hello!</h1>
        </div>
        <form action="" method="GET">
            <input type="text" name="git_message" id="git_message">
            <input type="text" name="git_message2" id="git_message2">
            <input type="submit" value="Pošalji" />
        </form>
    </div>

<?php 
    } else { ?>

        <h1><?php echo $_GET['git_message']; ?> </h1>

    <?php } ?>
 
    
    
</body>
</html>