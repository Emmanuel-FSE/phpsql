<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root','Bornchamp30');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST') {

$title = $_POST['title'];
$description = $_POST['description'];
$price = $_POST['price'];
$date = date('Y-m-d H:i:s');

if(!$title){
    $errors[] = 'Product title is required';
}
 if(!$price){
    $errors[] = 'Product price is reqiured';
 }

 if(empty($errors)){
    $image = $_FILES['image'] ?? null;
    if($image) {
        move_uploaded_file($image['tmp_name']);
    }
   $statement = $pdo->prepare("INSERT INTO products  (title, image, description, price, create_date) 
            VALUES (:title, :image, :description, :price, :date)");
    $statement->bindValue(':title', $title);
    $statement->bindValue(':image', '');
    $statement->bindValue(':description', $description);
    $statement->bindValue(':price', $price);
    $statement->bindValue(':date', $date);
    $statement->execute();
 }
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products CRUD</title>
    <link rel="stylesheet" href="app.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>
  <body>

  <h2>Create New Product</h2>
<?php if(!empty($errors)) {?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error){?>
      <div><?php echo $error ?></div>
    <?php } ?>
</div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
<div class="mb-3">
  <label class="form-label">Product Image</label>
  <input type="file" class="form-control" name="image">
</div>

<div class="mb-3">
  <label class="form-label">Product Title</label>
  <input type="text" class="form-control" name="title">
</div>

<div class="mb-3">
  <label class="form-label">Product Description</label>
  <textarea class="form-control" name="description"></textarea>
</div>

<div class="mb-3">
  <label class="form-label">Product Price</label>
  <input type="number" step=".01" name="price" class="form-control">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
<a href="index.php" class="emmax btn btn-success">View All Items</a>
</form>
  </body>
</html>