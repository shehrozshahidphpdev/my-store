<?php


class RecordManagerRepository
{
  private $conn;

  private $table;

  public function __construct($conn, $table)
  {
    $this->conn = $conn;
    $this->table = $table;
  }

  public function getAll()
  {
    $sql = "SELECT * FROM products";
    $stmt =  $this->conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function sortCreatedBy()
  {
    $sortSql = "SELECT * FROM products ORDER By created_at DESC";
    $stmt = $this->conn->prepare($sortSql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function search($query)
  {
    $searchSql = "SELECT * FROM products WHERE name LIKE :name OR  price LIKE :price OR  stock LIKE :stock OR description like :description";
    $stmt = $this->conn->prepare($searchSql);
    $stmt->execute([':name' => "%$query%", ':price' => "%$query%", ':stock' => "%$query%", ':description' => "%$query%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function sortHighPrice()
  {
    $sortSql = "SELECT * FROM products ORDER By price DESC";
    $stmt = $this->conn->prepare($sortSql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function sortPriceLow()
  {
    $sortSql = "SELECT * FROM products ORDER By price ASC";
    $stmt = $this->conn->prepare($sortSql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function sortActive()
  {
    $sortSql = "SELECT * FROM products WHERE status = 1";
    $stmt = $this->conn->prepare($sortSql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function sortInActive()
  {
    $sortSql = "SELECT * FROM products WHERE status = 0";
    $stmt = $this->conn->prepare($sortSql);
    $stmt->execute();
    return  $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function insert($data)
  {
    $sql = 'INSERT INTO products (name, slug, description, price, stock, status,  image) VALUES(:name, :slug, :description, :price, :stock, :status,  :image)';
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      ':name' => $data['name'],
      ':slug' => $slug ?? str_replace(" ", '-', $data['name']),
      ':description' => strtolower($data['description']),
      ':price' => $data['price'],
      ':stock' => $data['stock'],
      ':status' => $data['status'],
      ':image' => $data['image']
    ]);
  }

  public function delete($id)
  {
    $sql = "DELETE FROM products WHERE id = :id";
    $stmt = $this->conn->prepare($sql);
    return $stmt->execute([
      ':id' => $id
    ]);
  }

  public function getImage($id)
  {
    $stmt = $this->conn->prepare("SELECT image from products where id = :id");
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function update($data)
  {
    $sql = 'UPDATE products SET name = :name, slug = :slug, description = :description, price = :price, stock = :stock, status = :status,  image = :image WHERE id = :id';
    $stmt = $this->conn->prepare($sql);
    return  $stmt->execute([
      ':id' => $data['id'],
      ':name' => $data['name'],
      ':slug' => !isset($data['slug']) ? $data['slug'] : $data['userSlug'],
      ':description' => strtolower($data['description']),
      ':price' => $data['price'],
      ':stock' => $data['stock'],
      ':status' => $data['status'],
      ':image' => !empty($data['image']) ? $data['image'] : $data['previousImage']
    ]);
  }
}

$recordManagerRepository = new RecordManagerRepository($conn, 'products');
