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
          <div class="card-header">
            <h4 class="title">Products</h4>
            <a href="/products/create" class="btn">Create</a>
          </div>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Description</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Image</th>
                <th>Created At</th>
                <th>Updated At</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>iphone 17 pro max</td>
                <td>iphone-17-pro-max</td>
                <td>Lorem ipsum dolor sit amet</td>
                <td>1000</td>
                <td>20</td>
                <td>image.jpg</td>
                <td>2026-02-19</td>
                <td>2026-02-19</td>
              </tr>
            </tbody>
          </table>

        </div>
      </main>

    </div>
  </div>
</body>

</html>