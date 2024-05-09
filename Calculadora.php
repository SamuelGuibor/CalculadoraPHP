<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora do Samuelzin</title>

    <link rel="stylesheet" href="style.css">

    <?php

    session_start();

    $numero1 = 0;
    $numero2 = 0;
    $resultado = 0;
    $calcular = 0;

    function fatoracao($num)
    {
        $fat = array();
        for ($i = 2; $i <= $num; $i++) {
            while ($num % $i == 0) {
                $fat[] = $i;
                $num /= $i;
            }
        }
        return $fat;
    }

    if (!isset($_SESSION['historico'])) {
        $_SESSION['historico'] = array();
    }

    if (!isset($_SESSION['memoria'])) {
        $_SESSION['memoria'] = array('numero1' => 0, 'numero2' => 0, 'calcular' => 'somar');
    }

    if (isset($_GET['numero1'], $_GET['numero2'], $_GET['calcular'])) {
        $numero1 = $_GET['numero1'];
        $numero2 = $_GET['numero2'];
        $calcular = $_GET['calcular'];

        switch ($calcular) {
            case 'somar':
                $resultado = $numero1 + $numero2;
                break;
            case 'multiplicar':
                $resultado = $numero1 * $numero2;
                break;
            case 'subtrair':
                $resultado = $numero1 - $numero2;
                break;
            case 'dividir':
                $resultado = $numero1 / $numero2;
                break;
            case 'potencia':
                $resultado = pow($numero1, $numero2);
                break;
            case 'fatorar':
                $resultado = fatoracao($numero1);
                break;
        }

        $_SESSION['historico'][] = array(
            'numero1' => $numero1,
            'numero2' => $numero2,
            'calcular' => $calcular,
            'resultado' => $resultado
        );
    }

    if (isset($_GET['limparHistorico'])) {
        $_SESSION['historico'] = array();
    }

    if (isset($_GET['memoria'])) {
        $_SESSION['memoria'] = array('numero1' => $numero1, 'numero2' => $numero2, 'calcular' => $calcular);
    }

    ?>



</head>

<body>
    <form>
        <div class="caberalho">
            <h1>Calculadora PHP do Samuelzin</h1>
        </div>
        Primeiro número
        <input type="number" required name="numero1" value=<?php echo $numero1; ?> /> 
        
        Segundo número
        <input type="number" required name="numero2" value=<?php echo $numero2; ?> /> <br /> <br>

        <select name="calcular">
            <option value="somar" <?php echo ($calcular == 'somar') ? 'selected' : ''; ?>>Somar</option>
            <option value="multiplicar" <?php echo ($calcular == 'multiplicar') ? 'selected' : ''; ?>>Multiplicar</option>
            <option value="subtrair" <?php echo ($calcular == 'subtrair') ? 'selected' : ''; ?>>Subtrair</option>
            <option value="dividir" <?php echo ($calcular == 'dividir') ? 'selected' : ''; ?>>Dividir</option>
            <option value="potencia" <?php echo ($calcular == 'potencia') ? 'selected' : ''; ?>>Potência</option>
            <option value="fatorar" <?php echo ($calcular == 'fatorar') ? 'selected' : ''; ?>>Fatorar</option>
        </select>
        <br /><br />
        <input type="submit" class="botaoCalcular" value="Calcular"/>

        <input type="submit" class="botaoCalcular" name="limparHistorico" value="Limpar Histórico"/>

        <input type="submit" class="botaoCalcular" name="memoria" value="Memoria"/>



    </form>


    <h2>Histórico</h2>
    <table>
        <tr>
            <th>Numero 1</th>
            <th>Numero 2</th>
            <th>Operação</th>
            <th>Resultado</th>
        </tr>
        <?php foreach ($_SESSION['historico'] as $operação) : ?>
        <tr>
            <td><?php echo $operação['numero1']; ?></td>
            <td><?php echo $operação['numero2']; ?></td>
            <td><?php echo $operação['calcular']; ?></td>
            <td><?php echo is_array($operação['resultado']) ? implode(', ', $operação['resultado']) : $operação['resultado']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>

</body>

</html>