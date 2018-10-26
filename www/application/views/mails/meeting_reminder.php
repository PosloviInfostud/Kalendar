<html>
    <head>
        <title>Your meeting in <?= $room ?> is about to start!</title>
    </head>
    <body>
        <h2><?= $title ?></h2>
        <p><strong>When:</strong> <?= $start_time ?></p>
        <p><strong>Where:</strong> <?= $room ?></p>
        <p><strong>Duration:</strong> <?= $duration ?> mins</p>
        <p><strong>About:</strong> <?= $description ?></p>
    </body>
</html>