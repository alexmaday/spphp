<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Wanna Hear a Joke?</title>
</head>

<body>
    <ul>
        <?php foreach ($jokes as $joke) : ?>
        <blockquote>
            <p><?php echo htmlspecialchars($joke, ENT_QUOTES, 'UTF-8'); ?></p>
        </blockquote>
        <?php endforeach; ?>
    </ul>
</body>

</html> 
