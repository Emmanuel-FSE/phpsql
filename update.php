<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root','Bornchamp30');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_GET['id'] ?? null;

if(!id) {
    header('Location: index.php');
    exit;
}

$statement = $pdo->prepare('SELECT * FROM products WHERE id = :id');
$statement->bindValue(':id', $id);
$statement->execute();
$product = $statement->fetch(PDO::FETCH_ASSOC);



$errors = [];

$title = $product['title'];
$price = $product['price'];
$description = $product['description'];

// if($_SERVER['REQUEST_METHOD'] === 'POST') {

// $title = $_POST['title'];
// $description = $_POST['description'];
// $price = $_POST['price'];

// if(!$title){
//     $errors[] = 'Product title is required';
// }
//  if(!$price){
//     $errors[] = 'Product price is reqiured';
//  }

// if(!is_dir('images')){
//   mkdir('images');
// }

//  if(empty($errors)){
//     $image = $_FILES['image'] ?? null;
//     $imagePath = $product['image'];
//     if($product['image']){
//         unlink($product['image']);
//     }
//     if($image && $image['tmp_name']) {
//         $imagePath = 'images/'.randomString(8).'/'.$image['name'];
    
//         mkdir(dirname($imagePath));
        
//         move_uploaded_file($image['tmp_name'], $imagePath);
//     }
    
    
//    $statement = $pdo->prepare("UPDATE products  SET title = :title, image = :image, description = :decription, price = :price
//                                 WHERE id = :id"); 
//     $statement->bindValue(':title', $title);
//     $statement->bindValue(':image', $imagePath);
//     $statement->bindValue(':description', $description);
//     $statement->bindValue(':price', $price);
//     $statement->bindValue(':id', $id);
//     $statement->execute();
//     header('Location: index.php');
//  }
// }

// function randomString($n) {
//   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//   $str = '';
//   for ($i = 0; $i < $n; $i++) {
//       $index = rand(0, strlen($characters) -1);
//       $str .= $characters[$index];
//   }
//   return $str;
// }
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
 <a href="index.php" class="btn btn-secondary">Go to all products</a>
  <h2>Update Product <b><?php echo $product['title'] ?></b></h2>
<?php if(!empty($errors)) {?>
<div class="alert alert-danger">
    <?php foreach ($errors as $error){?>
      <div><?php echo $error ?></div>
    <?php } ?>
</div>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
    <?php
    if($product['image']){?>
        <img class="update-product" src="<?php echo $product['image'] ?>" alt="">
    <?php }
    ?>
<div class="mb-3">
  <label class="form-label">Product Image</label>
  <input type="file" class="form-control" name="image">
</div>

<div class="mb-3">
  <label class="form-label">Product Title</label>
  <input placeholder="<?php echo $product['title'] ?>"  type="text" class="form-control" name="title">
</div>

<div class="mb-3">
  <label class="form-label">Product Description</label>
  <textarea placeholder="<?php echo $product['description'] ?>"  class="form-control" name="description"></textarea>
</div>

<div class="mb-3">
  <label class="form-label">Product Price</label>
  <input placeholder="<?php echo $product['price'] ?>"  type="number" step=".01" name="price" class="form-control">
</div>
<button type="submit" class="btn btn-primary">Submit</button>
</form>
  </body>
</html>