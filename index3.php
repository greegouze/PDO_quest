<?php

require 'connect.php';
$pdo = new \PDO(DSN, USER, PASS);


$query = 'SELECT * FROM friend';
$statement = $pdo->query($query);
$friend = $statement->fetchAll(PDO::FETCH_ASSOC);


$errors = [];
$lastname = $_POST['lastname'];
$firstname = $_POST['firstname'];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  

   
    
    if(empty($lastname)){
        $errors[] = 'Erreur, le nom est requis';
    }
    if(empty($firstname)){
        $errors[] = 'Erreur, le prénom est requis';
    }

    if(empty($errors)){
        $queryPost = "INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)";

        $statement = $pdo->prepare($queryPost);
        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();
        
    
        header('Location: index3.php');
    }

    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDO</title>
</head>
<body>

    <section>
        <p>
            <ul>
                <?php foreach($friend as $friends) :?>
                    <li><?= $friends['lastname'] . ' ' . $friends['firstname'] ?></li>
                <?php endforeach ?>
            </ul>
        </p>
    </section>


    <section>
        <p>
            <ul>
                <?php foreach($errors as $error) : ?>
                    <li>
                        <?= $error ?>
                    </li>
                <?php endforeach ?>
            </ul>
            
        </p>
        <form method="POST">
            <label for="lastname">Nom</label>
            <input id="lastname" name="lastname" max="45" value="<?= $lastname ?>" required>

            <label for="firstname">Prénom</label>
            <input id="firstname" name="firstname" max="45" value="<?= $firstname ?>" required>

            <button id="submit">Submit</button>
        </form>
    </section>
    

</body>
</html>