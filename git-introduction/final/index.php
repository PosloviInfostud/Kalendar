<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Git integration</title>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<style>
body,html {
    height: 100%;
    background: url(http://www.salbii.com/wp-content/themes/salbii/images/wp-admin/layout-backgrounds/bgimg3.jpg);
    background-repeat: no-repeat;
    background-size: cover;
}
</style>
<body>
    <?php 
        if(empty($_POST['git_message'])) {
    ?>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            <h1 class="text-center" style="font-size:72pt;">Say hello!</h1>
            <form class="col-12" action="" method="POST">
            <div class="form-group">
                <input type="text" name="git_message" class="form-control" id="git_message">
                <p class="text-center" style="margin-top:10px;">
                <input class="btn btn-primary" type="submit" value="Pošalji" />
                </p>
            </div>
            </form>   
        </div>  
    </div>
    <?php 
        } else {
            ?>
                <div class="container h-100">
                    <div class="row h-100 justify-content-center align-items-center">
                        <h1 class="text-center" style="font-size:96pt;"><?= $_POST['git_message'] ?></h1>
                        </form>   
                    </div>  
                </div>
            <?php
        }
    ?>
</body>
</html>
<?php 

//echo "Hello Git!";

?>