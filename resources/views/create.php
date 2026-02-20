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
            <h4 class="title">Products </h4>
            <a href="/products" class="back-btn">Back</a>
          </div>

          <form action="/products/store" method="post" enctype="multipart/form-data">
            <div class="row">
              <div class="form-group">
                <label for="">Name</label>
                <input type="text" name="name" value="<?= $old['name'] ?? '' ?>" placeholder="Enter Product Name">
                <p class="error"><?= $errors['name'] ?? '' ?></p>
              </div>
              <div class="form-group">
                <label for="">Slug (Optional)</label>
                <input type="text" name="slug" value="<?= $old['slug'] ?? '' ?>">
                <p class="error"><?= $errors['slug'] ?? '' ?></p>
              </div>
            </div>
            <div class="row text-area">
              <label for="">Description</label>
              <textarea name="description" id="" rows="8">
                <?= $old['description'] ?? '' ?> 
              </textarea>
              <p class="error"><?= $errors['description'] ?? '' ?></p>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="">Price</label>
                <input type="number" name="price" placeholder="Enter Product Price" value="<?= $old['price'] ?? '' ?>">
                <p class="error"><?= $errors['price'] ?? '' ?></p>
              </div>
              <div class="form-group">
                <label for="">Stock</label>
                <input type="number" name="stock" value="<?= $old['stock'] ?? '' ?>">
                <p class="error"><?= $errors['stock'] ?? '' ?></p>
              </div>
            </div>
            <div class="row">
              <div class="form-group">
                <label for="">Image</label>
                <input type="file" name="image">
                <p class="error"><?= $errors['image'] ?? '' ?></p>
              </div>

              <div class="form-group">
                <label for="">Status (optional) default is active</label>
                <select name="status" id="">
                  <option value="" selected>-- Please Select Sttaus</option>
                  <option value="1">Active</option>
                  <option value="0">Not Active</option>
                </select>
              </div>
            </div>
            <button type="submit">Submit</button>
          </form>
        </div>
      </main>

    </div>
  </div>
</body>

</html>