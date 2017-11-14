<?php

function seleccion(array $elementos, ?string $actual, $nombre): void
{
?>
    <select id="<?= $nombre ?>" name="<?= $nombre ?>">
        <?php
        foreach ($elementos as $v) {
            option($actual, $v);
        }
    ?>
    </select>
<?php
}

function option($op, $v)
{ ?>
    <option value="<?= $v ?>" <?= selected($op, $v) ?> >
        <?= $v ?>
    </option>
<?php
}

function selected(?string $o, string $v): string
{
    return $o === $v ? 'selected': '';
}

function calcula($op1, $op2, $op)
{
    eval("\$ret = $op1 $op $op2;"); //Es peligroso, no usar.
    // switch ($op) {
    //     case '+':
    //         $ret = $op1 + $op2;
    //         break;
    //     case '-':
    //         $ret = $op1 - $op2;
    //         break;
    //     case '*':
    //         $ret =  $op1 * $op2;
    //         break;
    //     case '/':
    //         $ret =  $op1 / $op2;
    //         break;
    // }
    return $ret;
}

function checkParametros($op1, $op2, $op, &$error)
{
    if(!isset($op1, $op2, $op)) {
        if ($op1 !== null || $op2 !== null || $op !== null) {
            $error[] = 'Falta algún parámetro';
        }
        throw new Exception;
    } elseif ($op1 === '' || $op2 === '') {
        $error[] = 'Falta algún parámetro';
        throw new Exception;
    }
}

function checkNumeros($op1, $op2, &$error)
{
    if (!is_numeric($op1) || !is_numeric($op2)) {
        $error[] = 'Los dos operandos deben ser numéricos';
    }
}

function checkOperador($op, $array, &$error)
{
    if (!in_array($op, OPERACIONES)) {
        $error[] = 'Operador no válido';
    }
}

function checkError($error)
{
    if (!empty($error)) {
        throw new Exception;
    }
}

function mostrarError($error)
{
    if (!empty($error)) {
        foreach ($error as $v):
?>
            <h3><?= $v ?></h3>
<?php
        endforeach;
    }
}

function pintarFormulario($op1, $op2, $op, $array)
{
?>
    <form action="calcula3.php" method="get">
        <label for="op1">Primer operando:</label>
        <input id="op1" type="text" name="op1" value="<?= $op1 ?>" /><br />
        <label for="op2">Segundo operando:</label>
        <input id="op2" type="text" name="op2" value="<?= $op2 ?>" /><br />
        <label for="op">Operación:</label>
        <?php seleccion(OPERACIONES, $op, 'op') ?><br />
        <input type="submit" value="Calcular" />
    </form>
<?php
}
