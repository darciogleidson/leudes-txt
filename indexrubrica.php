<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Importar dados Excel</title>
    </head>
    <body>
        <h1>Updload Excel:</h1>

        <form method="POST" action="processa.php" enctype="multipart/form-data">
            <label>Arquivo</label>
            <input type="file" name="arquivo"><br><br>
            <label>Rubrica</label>
            <input type="text" name="rubrica" minlength="4" maxlength="4"><br><br>
            <label>Coluna das matrículas</label>
            <select name="col_mat">
                <option value="0">A</option>
                <option value="1" selected>B</option>
                <option value="2">C</option>
                <option value="3">D</option>
                <option value="4">E</option>
            </select><br><br>
            <label>Coluna dos valores</label>
            <select name="col_val">
                <option value="1">B</option>
                <option value="2" selected>C</option>
                <option value="3">D</option>
                <option value="4">E</option>
                <option value="5">F</option>
            </select><br><br>
            <label>Ano</label>
            <select name="ano">
                <option value="2022" selected>2022</option>
                <option value="2021">2021</option>
            </select><br><br>
            <label>Mês</label>
            <select name="mes">
                <option value="01" selected>01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select><br><br>
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>
