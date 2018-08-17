<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?
echo "<h1>Привет!</h1>";

echo PHP_EOL;

echo PHP_EOL;

echo $this->tag->linkTo(
'phalcon/signup',
'Регистрируйся!'
);

?>
</body>
</html>