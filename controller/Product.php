<?php

class Product
{
  public $conn;
  public $product;
  public function __construct($conn, RecordManagerRepository $product)
  {
    $this->conn = $conn;
    $this->product = $product;
  }

  public function index()
  {
    $products = $this->product->getAll();
    return view('list', ['products' => $products]);
  }

  public function search()
  {
    if (isset($_GET['search'])) {
      $query = $_GET['search'];
      $products = $this->product->search($query);
      return view('list', ['products' => $products]);
    }
  }

  public function sort()
  {
    if (isset($_GET['sort'])) {
      $sortType = $_GET['sort'];
      if ($sortType == 'default') {
        return header('Location: /products');
      } else if ($sortType == 'created_by_descending') {
        $products = $this->product->sortCreatedBy();
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'price_descending') {
        $products = $this->product->sortHighPrice();
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'price_ascending') {
        $products = $this->product->sortPriceLow();
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'status_active') {
        $products = $this->product->sortActive();
        return view('list', ['products' => $products]);
      } elseif ($sortType == 'status_inactive') {
        $products = $this->product->sortInActive();
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
    $data = [];
    $data = [
      'name' => $name,
      'slug' => $slug,
      'description' => $description,
      'price' => $price,
      'stock' => $stock,
      'status' => $status,
      'image' => $files['image']['name']
    ];

    $result = $this->product->insert($data);
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
    $slug = str_replace(" ", "-", $name);
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
    $previousImage = $this->product->getImage($id);
    // dd($previousImage);

    $data = [];
    $data = [
      'id' => $id,
      'name' => $name,
      'slug' => $slug,
      'description' => $description,
      'price' => $price,
      'stock' => $stock,
      'status' => $status,
      'image' => $files['image']['name'],
      'previousImage' => $previousImage['image'],
      'userSlug' => $userSlug
    ];


    $response = $this->product->update($data);

    if ($response) {
      session("success", "Product Updated Successfully");
      return header('Location: /products');
    } else {
      echo "Something went wrong";
    }
  }

  public function destroy($id)
  {
    $this->product->delete($id);
    session("success", "Product Deleted Successfully");
    return header('Location: /products');
  }
}
$product = new Product($conn, $recordManagerRepository);
