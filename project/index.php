<?php
require_once('database.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (isset($_POST["submit"])) {

        if (empty($_POST["name"]) || empty($_POST["description"]) || empty($_POST["price"])) {

            echo "Name/description/price is missing!!";
        } else {

            $productNameInput = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $descriptionInput = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
            $priceInput = filter_input(INPUT_POST, "price", FILTER_SANITIZE_SPECIAL_CHARS);

            $priceValidate = filter_var($priceInput, FILTER_VALIDATE_FLOAT);

            if ($priceValidate == false) {

                echo "Price's data is not valid";
            } else {

                try {

                    $sql = "INSERT INTO clothes (name, description, price) VALUES (?, ?, ?)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([$productNameInput, $descriptionInput, $priceInput]);
                } catch (PDOException $e) {

                    echo "" . $e->getMessage();
                }
            }
        }
    } else {

        echo "Error request.";
    }

    $getSql = "SELECT id, name, description, price FROM clothes";
    $stmt = $pdo->prepare($getSql);
    $stmt->execute();

    $products = [];
    if ($stmt->rowCount() > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $products[] = $row;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Каталог карточек</title>
</head>

<body>
    <div class="form-container">
        <h1>Добавить товар в каталог: </h1>
        <form class="add-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
            <label for="">Имя товара: </label>
            <input type="text" name="name"><br>
            <label for="">Описание товара: </label>
            <textarea name="description" id="" placeholder="Введите описание товара"></textarea><br>
            <label for="">Цена товара: </label>
            <input type="text" name="price"><br>
            <input type="submit" name="submit" value="Добавить товар">
        </form>

    </div>

    <div class="catalog-conteiner">
        <?php if (!empty($products)) {

            foreach ($products as $product) {

                echo  '<div class="card">';
                echo  '<div class="product-name">' . htmlspecialchars($product['name']) . '</div>';
                echo     '<div class="product-description">' . htmlspecialchars($product['description']) . '</div>';
                echo    '<div class="product-price">' . htmlspecialchars($product['price']) . '</div>';
                echo    '<button class="card-btn">Купить</button>';
                echo '</div>';
            }

        }else{

            echo "Товары не найдены!!";

        }
        ?>

    </div>
</body>

</html>


