<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tablas de Multiplicar</title>
    <style>
        .resultado {
            border: 1px solid black; 
            padding: 5px; 
            display: inline-block; 
        }
        .correcta {
            color: green;
        }
        .incorrecta {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Tablas de Multiplicar</h2>
    <form method="post">
        <label for="numero">Ingrese un numero para la tabla:</label>
        <input type="number" min="1" name="numero" required>
        <label for="rango_inicio">Rango de inicio:</label>
        <input type="number" min="1" name="rango_inicio" required>
        <label for="rango_fin">Rango de fin:</label>
        <input type="number" min="1" name="rango_fin" required>
        <input type="submit" name="submit" value="Generar tabla">
    </form>

    
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        $numero = $_POST["numero"];
        $rango_inicio = $_POST["rango_inicio"];
        $rango_fin = $_POST["rango_fin"];
        

        $min = min($rango_inicio, $rango_fin);
        $max = max($rango_inicio, $rango_fin);
        

        echo "<h3>Tabla de multiplicar del $numero, en el rango $min a $max:</h3>";
        echo "<form method='post'>"; 
        echo "<table>";
        $resultados_esperados = array(); 
        foreach (range($min, $max) as $i) {
            echo "<tr>";
            echo "<td>$numero x $i = </td>";
            echo "<td><input type='text' name='respuesta[$i]' value='";
            if(isset($_POST['respuesta'][$i])) {
                echo $_POST['respuesta'][$i];
            }
            echo "'></td>"; 
            echo "</tr>";
            $resultados_esperados[$i] = $numero * $i; 
        }
        echo "</table>";
        echo "<input type='hidden' name='numero' value='$numero'>";
        echo "<input type='hidden' name='rango_inicio' value='$rango_inicio'>";
        echo "<input type='hidden' name='rango_fin' value='$rango_fin'>";
        echo "<input type='submit' name='calificar' value='Calificar'>"; 
        echo "</form>";
    }
    ?>
    
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["calificar"])) {
    $numero = $_POST["numero"];
    $rango_inicio = $_POST["rango_inicio"];
    $rango_fin = $_POST["rango_fin"];
    
    $min = min($rango_inicio, $rango_fin);
    $max = max($rango_inicio, $rango_fin);

    echo "<h3>Respuestas:</h3>";
    echo "<ul>";
    $respuestas_correctas = 0;
    $total_preguntas = 0;
    foreach (range($min, $max) as $i) {
        echo "<li>$numero x $i = " . ($numero * $i) . " (Respuesta correcta)";
        $total_preguntas++;
        if ($_POST["respuesta"][$i] == $numero * $i) {
            echo " <span class='correcta'>(Correcta)</span>";
            $respuestas_correctas++;
        } else {
            echo " <span class='incorrecta'>(Incorrecta - {$_POST['respuesta'][$i]})</span>";
        }
        echo "</li>";
    }
    echo "</ul>";

    echo "<h3>Cantidad de aciertos:</h3>";
    echo "<p>$respuestas_correctas / $total_preguntas</p>";

  
    $porcentaje_correctas = ($respuestas_correctas / $total_preguntas) * 100;
    echo "<h3>Promedio de calificacion:</h3>";
    echo "<p>$porcentaje_correctas%</p>";

    echo "<form method='post'>";
    echo "<input type='submit' name='submit' value='Generar nueva tabla'>";
    echo "</form>";
}
?>

</body>
</html>
