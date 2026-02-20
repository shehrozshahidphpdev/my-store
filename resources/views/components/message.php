  <div class="success-message">
    <span><?= $_SESSION['success']  ?></span>
  </div>

  <script>
    const msg = document.querySelector('.success-message');
    setTimeout(() => {
      msg.style.display = 'none';
    }, 3000);
  </script>