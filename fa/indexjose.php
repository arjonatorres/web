<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Listado de películas</title>
    </head>
    <body>
        <?php
        $pdo = new PDO('pgsql:host=localhost;dbname=fa', 'fa', 'fa');
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $q1 = 0;
        if ($id) {
            $q1 = $pdo->query("DELETE FROM peliculas WHERE id={$id}")->rowCount();
        }
        $query = $pdo->query('SELECT * FROM peliculas');
        // Podemos quitar esta fila porque es iterable
        // $filas = $query->fetchAll();
        ?>
        <form action="indexjose.php" method="post">

        <table border="1">
            <thead>
                <th>Id</th>
                <th>Título</th>
                <th>Año</th>
                <th>Sinopsis</th>
                <th>Duración</th>
                <th>Género</th>
            </thead>
            <tbody>
                <?php foreach ($query as $fila): ?>
                    <tr>
                        <td><?= $fila['id'] ?></td>
                        <td><?= $fila['titulo'] ?></td>
                        <td><?= $fila['anyo'] ?></td>
                        <td><?= $fila['sinopsis'] ?></td>
                        <td><?= $fila['duracion'] ?></td>
                        <td><?= $fila['genero_id'] ?></td>
                        <td><button value="<?= htmlentities($fila['id']) ?>" name="id">Borrar fila</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
    <?php if ($q1 === 1): ?>
        <h3>La fila ha sido borrada con éxito</h3>
    <?php endif; ?>
    </body>
</html>
