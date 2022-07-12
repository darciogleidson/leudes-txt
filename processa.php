<?php
    $dados = $_FILES['arquivo'];
    ini_set('MAX_EXECUTION_TIME', 1000);

    if (!empty($_FILES['arquivo']['tmp_name'])){
        $arquivo = new DomDocument();
        $arquivo->load($_FILES['arquivo']['tmp_name']);

        $linhas = $arquivo->getElementsByTagName("Row");
        $array = array();

        //obs: a planilha do 147 não aceitou esse (int)
        //$col_mat = (int)$_POST['col_mat'];
        //$col_val = (int)$_POST['col_val'];
        
        $col_mat = $_POST['col_mat'];
        $col_val = $_POST['col_val'];

        $valorplanilha = 0;
        $codigo_orgao = "0103";
        $codigo_processamento = "0";
        $rubrica = "00" . $_POST['rubrica'];
        $operacao = "1";
        $tipo = "0";
        $QVF = "   ";
        $horas = "   ";
        $minutos = "  ";
        $tipo_base_calculo = "  ";
        $codigo_base_calculo = "      ";
        $tipo_fator = " ";
        $valor_fator = "           ";

        $numero_linhas = 0;

        foreach($linhas as $linha){

            $numero_linhas = $numero_linhas + 1;

            if (isset($linha->getElementsByTagName("Data")->item(0)->nodeValue)){
                $nome = $linha->getElementsByTagName("Data")->item(0)->nodeValue;
            }

            if (isset($linha->getElementsByTagName("Data")->item($col_mat)->nodeValue)){
                $matricula = $linha->getElementsByTagName("Data")->item($col_mat)->nodeValue;
                //As vezes vem ponto na matricula, substituir por nada
                $matricula = str_replace('.', '', trim($matricula));
                //retirando separador
                $matricula = str_replace('-','',$matricula);
                $matricula = str_replace('–','',$matricula);               
            }

            if (isset($linha->getElementsByTagName("Data")->item($col_val)->nodeValue)){
                if (is_numeric($linha->getElementsByTagName("Data")->item($col_val)->nodeValue)){
                    
                    //Testar o tamanho da Matricula
                    if (strlen($matricula) <> 8){

                      //PROBLEMA: Quando matricula comeca com 0 ele tá trazendo sem o 0 assim não dá pra contar
                      //exit ('Na linha ' . $numero_linhas . ' Matricula '.$matricula.' com ' . strlen($matricula) . ' caracteres');
                    }

                    $valor = number_format($linha->getElementsByTagName("Data")->item($col_val)->nodeValue, 2, '.', '');
                    if (array_key_exists($matricula, $array)) {
                        $array[$matricula] += $valor;
                    } else {
                        $array[$matricula] = $valor;
                    }

                    $valorplanilha += $valor;
                }
            }

        }

        $fp = fopen("c:\\xampp\\".$rubrica.".txt","w");

        $valortotal = 0;
        $ano = $_POST['ano'];
        $mes = $_POST['mes'];

        $fruit = $array;
        reset($fruit);
        while (list($key, $val) = each($fruit)) {
            $valortotal += $val;
            //retirando separador
            $matricula = str_replace("-","",$key);
            $matricula = str_replace("–","",$key);

            //completando com zero a esquerda
            $matricula = str_pad($matricula, 9, '0', STR_PAD_LEFT);

            //retirando ponto
            $valor = str_replace(".","",number_format($val,2, '.', ''));
            //completando com zero a esquerda
            $valor = str_pad($valor, 11, '0', STR_PAD_LEFT);

            $linha = $ano . $mes . $codigo_orgao . $codigo_processamento .  $matricula . $rubrica . $valor . $operacao .
                    $tipo . $QVF . $horas . $minutos . $tipo_base_calculo . $codigo_base_calculo . $tipo_fator . $valor_fator;
            fwrite($fp, $linha . PHP_EOL);
            if (strlen($linha) <> 67){
              fclose($fp);
              echo $linha;
              echo '<br>';
              exit($matricula . ' - Linha com tamanho da coluna diferente de 67');
            }
        }

        fclose($fp);

        print_r('Valor Planilha: ' . $valorplanilha);
        echo "<br>";
        print_r('Valor TXT: ' . $valortotal);
        echo "<br>";

        if (($valorplanilha - $valortotal) <> 0 ){
            echo 'ERRO!!!!! Diferença = ' . ($valorplanilha - $valortotal);
        }

    } else {
        echo "Nenhum arquivo selecionado";
        echo "<br><br>";
        echo "<button onclick='goBack()'>Voltar</button>";


    }

?>

<script>
    function goBack() {
    window.history.back();
    }
</script>
