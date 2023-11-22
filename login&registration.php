<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/styles/main.css">
</head>
<body>
    <h1>Login</h1>

    <form action="controllers/authController.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <h2>Belum punya akun? Daftar di sini:</h2>

    <form action="controllers/registerController.php" method="post">

        <label for="newEmail">Username:</label>
        <input type="text" id="newEmail" name="newEmail" required>

        <label for="newUsername">Username:</label>
        <input type="text" id="newUsername" name="newUsername" required>

        <label for="newPassword">Password:</label>
        <input type="password" id="newPassword" name="newPassword" required>

        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required>

        <button type="submit">Daftar</button>
    </form>

    <script src="assets/scripts/jquery.js"></script>
    <script src="assets/scripts/custom.js"></script>
</body>
</html>
