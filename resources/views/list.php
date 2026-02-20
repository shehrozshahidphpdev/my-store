<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
            <div class="left">
              <h4 class="title">Products</h4>
              <form action="/products/sort" method="get">
                <select name="sort" id="sort" onchange="this.form.submit()">
                  <option disabled selected>sort</option>
                  <option value="default">Default</option>
                  <option value="created_by_descending">Sort By Date</option>
                  <option value="price_descending">Price High To low</option>
                  <option value="price_ascending">Price Low To High</option>
                  <option value="status_active">Status Active</option>
                  <option value="status_inactive">Status InActive</option>
                </select>
              </form>
            </div>
            <div class="right">
              <form action="/products/search" method="get" class="search-form">
                <input type="search" name="search" class="search" placeholder="Search Something Here">
                <button type="submit" class="btn">Submit</button>
              </form>

              <a href="/products" class="logout-btn">Clear</a>

              <a href="/products/create" class="btn">Create</a>
            </div>
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
                <th>Status</th>
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
                  <td><?= $product['status'] ?></td>
                  <td><img src="<?= UPLOADS_PATH . $product['image'] ?>" alt="product image" style="height: 50px; width: 50px;"></td>
                  <td>
                    <?php
                    $id = $product['id'];
                    ?>
                    <a class="icon" href="/product/edit?id=<?= $id ?>" style="color: blue;"><i class="fas fa-edit"></i></a>
                    <a class="icon" href="/product/delete?id=<?= $id ?>" style="color: red;"><i class="fa-solid fa-trash"></i></a>
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