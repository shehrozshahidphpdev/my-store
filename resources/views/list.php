<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>

<body>
  <div class="layout">
    <?php include_once COMPONENTS_PATH . 'admin/sidebar.php'; ?>

    <div class="body">
      <?php include_once COMPONENTS_PATH . 'admin/header.php'; ?>

      <main class="main">
        <div class="card">
          <div class="card__header">
            <h4>Products</h4>
            <a href="/products/create" class="btn">Create</a>
          </div>
          <div class="table">
            <thead>
              <tr>
                <td>#</td>
                <td>#</td>
                <td>#</td>
                <td>#</td>
              </tr>
            </thead>
          </div>
        </div>
      </main>

    </div>
  </div>
</body>

</html>