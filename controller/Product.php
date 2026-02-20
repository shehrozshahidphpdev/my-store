<?php

class Product
{
  public $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  public function index()
  {
    $sql = "SELECT * FROM products";
    $stmt =  $this->conn->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return view('list', ['products' => $products]);
  }

  public function store($request, $files)
  {
    $name = trim($request['name']);
    $slug = trim($request['slug']);
    $description = trim($request['description']);
    $price = trim($request['price']);
    $stock = trim($request['stock']);
    $image = $files['image']['name'];

    $validated = $this->validateProductStoreRequest($name, $slug, $description, $price, $stock, $image);
    if (!$validated) {
      $_SESSION['old'] = $request;
      header('Location: /products/create');
      exit();
    }
    if (isset($files['image'])) {
      $destination = BASE_PATH . '/public/uploads/';
      $path  = $destination . basename($files['image']['name']);
      $path = str_replace(" ", "", $path);
      move_uploaded_file($files['image']['tmp_name'], $path);
    }

    $sql = 'INSERT INTO products (name, slug, description, price, stock, image) VALUES(:name, :slug, :description, :price, :stock, :image)';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ':name' => $name,
      ':slug' => $slug ?? str_replace(" ", '-', $name),
      ':description' => strtolower($description),
      ':price' => $price,
      ':stock' => $stock,
      ':image' => $files['image']['name']
    ]);
    $_SESSION['success'] = "Product Created Successfully";
    header('Location: /products');
    exit();
  }
  function validateProductStoreRequest(string $name, string $slug, string $description, string $price, string $stock, $image)
  {
    $_SESSION['errors'] = [];
    if (empty($name)) {
      $_SESSION['errors']['name'] = "The name field is required";
    }
    if (empty($slug)) {
      $_SESSION['errors']['slug'] = "The slug field is required";
    }
    if (empty($description)) {
      $_SESSION['errors']['description'] = "The description field is required";
    }
    if (empty($price)) {
      $_SESSION['errors']['price'] = "The price field is required";
    }
    if (empty($stock)) {
      $_SESSION['errors']['stock'] = "The stock field is required";
    }
    if (empty($image)) {
      $_SESSION['errors']['image'] = "The image field is required";
    }

    if (empty($_SESSION['errors'])) {
      return true;
    }

    return false;
  }

  public function edit(int $id)
  {
    $sql = "SELECT *  FROM products WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return view('edit', ['data' => $data]);
  }

  public function update($request, $files)
  {
    $name = trim($request['name']);
    $slug = trim($request['slug']);
    $description = trim($request['description']);
    $price = trim($request['price']);
    $stock = trim($request['stock']);
    $image = $files['image']['name'];

    $validated = $this->validateProductStoreRequest($name, $slug, $description, $price, $stock, $image);
    if (!$validated) {
      $_SESSION['old'] = $request;
      header('Location: /products/create');
      exit();
    }
    if (isset($files['image'])) {
      $destination = BASE_PATH . '/public/uploads/';
      $path  = $destination . basename($files['image']['name']);
      $path = str_replace(" ", "", $path);
      move_uploaded_file($files['image']['tmp_name'], $path);
    }

    $sql = 'INSERT INTO products (name, slug, description, price, stock, image) VALUES(:name, :slug, :description, :price, :stock, :image)';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ':name' => $name,
      ':slug' => $slug ?? str_replace(" ", '-', $name),
      ':description' => strtolower($description),
      ':price' => $price,
      ':stock' => $stock,
      ':image' => $files['image']['name']
    ]);
    $_SESSION['success'] = "Product Created Successfully";
    header('Location: /products');
    exit();
  }

  public function destroy($id)
  {
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $result = $stmt->execute([
      ':id' => $id
    ]);
    if ($result) {
      session("success", "Product Deleted Successfully");
      return header('Location: /products');
    }
  }
}
$product = new Product($conn);
