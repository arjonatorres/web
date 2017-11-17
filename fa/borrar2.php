<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Pregunta si borrar</title>
    </head>
    <body>
        <?php
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? false;
        try {
            if ($id === false) {
                throw new Exception('Parámetro no válido');
            }
            $pdo = new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa');
            $query = $pdo->prepare('SELECT *
                                      FROM peliculas
                                     WHERE id = :id');
            $query->execute([':id'=>$id]);
            $fila = $query->fetch();

            if (empty($fila)) {
                throw new Exception('La Película no existe');
            }
            ?>
            <h3>
                ¿Seguro que deseas borrar la película "<?= $fila['titulo'] ?>"?
            </h3>
            <form action="hacerborrado2.php" method="post">
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" value="Si" />
                <input type="submit" value="No" formaction="index2.php" formmethod="get">
            </form>
            <?php
        } catch (Exception $e) {
        ?>
        <h3>Error: <?= $e->getMessage() ?></h3>
        <a href="index2.php">Volver</a>
        <?php
        }
        ?>
    </body>
</html>
