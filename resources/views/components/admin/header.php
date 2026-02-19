<header class="header">
  <div class="row">
    <p class="welcome">Welcome <?php echo $_SESSION['user']['name'] ?? "Guest" ?></p>
    <a href="/logout" class="logout-btn">Logout</a>
  </div>
</header>