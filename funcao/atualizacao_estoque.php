<?php
error_reporting(E_ALL);
ini_set("display_errors", 0); // Definido como 0 para evitar a exibição de erros no navegador

// Verifica se o arquivo foi enviado e se não está vazio
if (!empty($_FILES['enviar_material']['tmp_name'])) {
    // Conexão com o banco de dados
    $con = mysqli_connect('10.2.1.4', 'remoto', 'XTKfAFKPHNhWpSqW', 'sistemagsgalmoxarifado');
    if (!$con) {
        die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
    }

    // Abre o arquivo enviado e lê os dados linha por linha
    $arquivo = fopen($_FILES['enviar_material']['tmp_name'], 'r');
    if ($arquivo) {
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            $valor = explode('@@@@', $linha);

            // Obtém os valores da linha
            $codMaterial = mysqli_real_escape_string($con, $valor[1]);
            $valorUnit = mysqli_real_escape_string($con, $valor[2]);
            $estoqSAP = mysqli_real_escape_string($con, $valor[3]);
            $valorTotal = mysqli_real_escape_string($con, $valor[4]);

            // Executa a consulta SQL
            $qr = mysqli_query($con, "UPDATE `tb_inventario` SET `col_estoqSAP` = '$estoqSAP', `col_valorUnitario` = '$valorUnit', `col_valorTotal` = '$valorTotal', `col_dataImportacao` = NOW() WHERE col_codMaterial='$codMaterial'");
            
            // Verifica se a consulta foi bem-sucedida
            if ($qr) {
                if(mysqli_affected_rows($con) > 0){
                    echo "<h1> ATUALIZADO COM SUCESSO AO BANCO DE DADOS! </h1>";
                } else {
                    echo "<h1> Nenhuma linha afetada. </h1>";
                }
            } else {
                echo "<h1> ERRO AO ATUALIZAR O BANCO DE DADOS! </h1>";
            }
        }
        fclose($arquivo); // Fecha o arquivo após a leitura
    } else {
        echo "<h1> ERRO AO ABRIR O ARQUIVO! </h1>";
    }
    mysqli_close($con); // Fecha a conexão com o banco de dados
}
?>
