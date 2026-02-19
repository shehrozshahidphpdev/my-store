<?php

$errors = $_SESSION['errors'] ?? [];
$old = $_SESSION['old'] ?? [];
unset($_SESSION['errors']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>

<body>
  <main class="register">
    <div class="register__container">
      <h1 class="register__title">Register</h1>
      <form action="/register/store" method="POST" class="register__form">
        <div class="register__field">
          <label class="register__label" for="name">Name</label>
          <input class="register__input" type="text" name="name" value="<?= $old['name'] ?? '' ?>" placeholder="Enter your name">
          <p class="error"><?= $errors['name'] ?? '' ?></p>
        </div>

        <div class="register__field">
          <label class="register__label" for="email">Email</label>
          <input class="register__input" type="text" name="email" value="<?= $old['email'] ?? '' ?>" placeholder="Enter your email">
          <p class="error"><?= $errors['email'] ?? '' ?></p>

        </div>

        <div class="register__field">
          <label class="register__label" for="password">Password</label>
          <input class="register__input" type="password" name="password" value="<?= $old['password'] ?? '' ?>" placeholder="Enter password">
          <p class="error"><?= $errors['password'] ?? '' ?></p>

        </div>

        <div class="register__field">
          <label class="register__label" for="password">Confirm Password</label>
          <input class="register__input" type="password" name="password_confirmation" placeholder="Confirm Password">
        </div>
        <button type="submit" class="register__button">Register</button>
        <p class="register__bottom">Already Registered? <span class="login"><a href="/login" class="login">Login</a></span></p>
      </form>
    </div>
  </main>
</body>

</html>