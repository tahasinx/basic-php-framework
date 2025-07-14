<!DOCTYPE html>
<html>

<head>
    <title>User <?= htmlspecialchars($id) ?></title>
</head>

<body>
    <h1>User ID: <?= htmlspecialchars($id) ?></h1>
    <p>
        <a href="<?= $router->route('user.show', ['id' => $id]) ?>">View this user by named route</a>
    </p>
</body>

</html>