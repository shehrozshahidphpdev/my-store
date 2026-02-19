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
  <title>Login</title>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
  <style>

  </style>
</head>

<body>
  <?php if (isset($_SESSION['success'])) {
    include_once COMPONENTS_PATH . 'message.php';
    unset($_SESSION['success']);
  } ?>
  <main class="register">
    <div class="register__container">
      <h1 class="register__title">Login</h1>
      <form action="/login/attempt" method="POST" class="register__form">
        <div class="register__field">
          <label class="register__label" for="email">Email</label>
          <input class="register__input" type="text" name="email" placeholder="Enter your email">
          <p class="error"><?= $errors['email'] ?? '' ?></p>
        </div>

        <div class="register__field">
          <label class="register__label" for="password">Password</label>
          <input class="register__input" type="password" name="password" placeholder=" Enter password">
          <p class="error"><?= $errors['password'] ?? '' ?></p>
        </div>
        <button type="submit" class="register__button">Login</button>


        <p class="register__bottom">Not have an account? <span class="login"><a href="/register" class="login">register</a></span></p>
      </form>
    </div>
  </main>
</body>

</html>