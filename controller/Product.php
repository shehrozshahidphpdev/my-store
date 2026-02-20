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

  public function search()
  {
    if (isset($_GET['search'])) {
      $query = $_GET['search'];
      $searchSql = "SELECT * FROM products WHERE name LIKE :name OR  price LIKE :price OR  stock LIKE :stock OR description like :description";
      $stmt = $this->conn->prepare($searchSql);
      $stmt->execute([':name' => "%$query%", ':price' => "%$query%", ':stock' => "%$query%", ':description' => "%$query%"]);
      $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
      return view('list', ['products' => $products]);
    }
    // die('here');
  }

  public function sort()
  {
    if (isset($_GET['sort'])) {
      $sortType = $_GET['sort'];
      if ($sortType == 'default') {
        return header('Location: /products');
      } else if ($sortType == 'created_by_descending') {
        $sortSql = "SELECT * FROM products ORDER By created_at DESC";
        $stmt = $this->conn->prepare($sortSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'price_descending') {
        $sortSql = "SELECT * FROM products ORDER By price DESC";
        $stmt = $this->conn->prepare($sortSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'price_ascending') {
        $sortSql = "SELECT * FROM products ORDER By price ASC";
        $stmt = $this->conn->prepare($sortSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'status_active') {
        $sortSql = "SELECT * FROM products WHERE status = 1";
        $stmt = $this->conn->prepare($sortSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'status_inactive') {
        $sortSql = "SELECT * FROM products WHERE status = 0";
        $stmt = $this->conn->prepare($sortSql);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return view('list', ['products' => $products]);
      }
    }
  }

  public function store($request, $files)
  {
    $name = trim($request['name']);
    $status = $request['status'];
    $slug = trim($request['slug']);
    $description = trim($request['description']);
    $price = trim($request['price']);
    $stock = trim($request['stock']);
    $image = $files['image']['name'];

    $validated = $this->validateProductStoreRequest($name,  $description, $price, $stock, $image);
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

    $sql = 'INSERT INTO products (name, slug, description, price, stock, status,  image) VALUES(:name, :slug, :description, :price, :stock, :status,  :image)';
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ':name' => $name,
      ':slug' => $slug ?? str_replace(" ", '-', $name),
      ':description' => strtolower($description),
      ':price' => $price,
      ':stock' => $stock,
      ':status' => $status,
      ':image' => $files['image']['name']
    ]);
    $_SESSION['success'] = "Product Created Successfully";
    header('Location: /products');
    exit();
  }
  function validateProductStoreRequest(string $name,  string $description, string $price, string $stock, $image)
  {
    $_SESSION['errors'] = [];
    if (empty($name)) {
      $_SESSION['errors']['name'] = "The name field is required";
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
    if (!isset($_GET['id'])) {
      if (empty($image)) {
        $_SESSION['errors']['image'] = "The image field is required";
      }
    }

    if (empty($_SESSION['errors'])) {
      return true;
    }

    return false;
  }

  public function edit($id)
  {
    $sql = "SELECT *  FROM products WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute([
      ':id' => $id
    ]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    return view('edit', ['data' => $data]);
  }

  public function update($request, $files,  $id)
  {
    // dd($files);
    $name = trim($request['name']);
    $slug = trim($request['slug']);
    $description = trim($request['description']);
    $price = trim($request['price']);
    $stock = trim($request['stock']);
    $status = $request['status'];
    $image = $files['image']['name'];
    $userSlug = str_replace(" ", '-', $name);

    $validated = $this->validateProductStoreRequest($name,  $description, $price, $stock, $image);

    if (!$validated) {
      $_SESSION['old'] = $request;
      return header('Location: /product/edit?id=' . $id);
    }

    if (($files['image']['tmp_name'])) {
      // die('set');
      $destination = BASE_PATH . '/public/uploads/';
      $path  = $destination . basename($files['image']['name']);
      $path = str_replace(" ", "", $path);
      move_uploaded_file($files['image']['tmp_name'], $path);
    }
    // getting provious img if not upload again 
    $stmt = $this->conn->prepare("SELECT image from products where id = :id");
    $stmt->execute([':id' => $id]);
    $previousImage = $stmt->fetch(PDO::FETCH_ASSOC);
    // dd($previousImage);


    $sql = 'UPDATE products SET name = :name, slug = :slug, description = :description, price = :price, stock = :stock, status = :status,  image = :image WHERE id = :id';
    $stmt = $this->conn->prepare($sql);
    $res = $stmt->execute([
      ':id' => $id,
      ':name' => $name,
      ':slug' => !isset($slug) ? $slug : $userSlug,
      ':description' => strtolower($description),
      ':price' => $price,
      ':stock' => $stock,
      ':status' => $status,
      ':image' => !empty($files['image']['name']) ? $files['image']['name'] : $previousImage['image']
    ]);
    if ($res) {
      session("success", "Product Updated Successfully");
      return header('Location: /products');
    } else {
      echo "Something went wrong";
    }
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
