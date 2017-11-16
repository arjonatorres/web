<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Calculadora</title>
    </head>
    <body>
        <?php
        require 'auxiliar3.php';
        define('OPERACIONES', ['+', '-', '*', '/']);
        //$op1 = $op2 = $op = null;
        //extract($_GET, EXTR_IF_EXISTS);
        $op1 = filter_input(INPUT_GET,'op1');
        $op2 = filter_input(INPUT_GET,'op2');
        $op = filter_input(INPUT_GET,'op');
        var_dump($op1);
        var_dump($op2);
        var_dump($op);
        $error = [];
        try {
            compruebaParametros($op1, $op2, $op, $error);
            compruebaOperador($op, OPERACIONES, $error);
            compruebaOperandos($op1, $op2, $error);
            compruebaErrores($error);
            $op1 = calcula($op1, $op2, $op);
        } catch (Exception $e) {
            mostrarErrores($error);
        }
        dibujaFormulario($op1, $op2, $op, OPERACIONES);
        ?>
    </body>
</html>
