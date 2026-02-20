<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
</head>

<body>
  <?php if (isset($_SESSION['success'])) {
    include_once COMPONENTS_PATH . 'message.php';
    unset($_SESSION['success']);
  } ?>

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
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($products as $product) { ?>
                <tr>
                  <td><?= $product['id'] ?></td>
                  <td><?= $product['name'] ?></td>
                  <td><?= $product['slug'] ?></td>
                  <td><?= $product['description'] ?></td>
                  <td><?= $product['price'] ?></td>
                  <td><?= $product['stock'] ?></td>
                  <td><img src="<?= UPLOADS_PATH . $product['image'] ?>" alt="product image" style="height: 50px; width: 50px;"></td>
                  <td>
                    <?php
                    $id = $product['id'];
                    ?>
                    <a href="/product/edit?id=<?= $id ?>">edit</a>
                    <a href="/product/delete?id=<?= $id ?>" style="color: red;">delete</a>
                  </td>
                </tr>
              <?php  }
              ?>
            </tbody>
          </table>

        </div>
      </main>

    </div>
  </div>
</body>

</html>