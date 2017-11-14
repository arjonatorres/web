<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Calculadora</title>
    </head>
    <body>
        <?php
        $op1 = $op2 = $op = null;
        extract($_GET, EXTR_IF_EXISTS);
        require 'auxiliar2.php';
        define('OPERACIONES', ['+', '-', '*', '/']);
        $error = [];
        try {
            checkParametros($op1, $op2, $op, $error);
            checkNumeros($op1, $op2, $error);
            checkOperador($op, OPERACIONES, $error);
            checkError($error);
            $op1 = calcula($op1, $op2, $op);
        } catch (Exception $e) {
            mostrarError($error);
        }
        pintarFormulario($op1, $op2, $op, OPERACIONES);
        ?>
    </body>
</html>
