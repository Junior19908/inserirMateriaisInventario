<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Processamento de Materiais</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            text-align: center;
        }

        button[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        button[type="button"]:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <div class="container">
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

                    // Extrai os valores de cada parte da linha
                    $codMaterial = mysqli_real_escape_string($con, $valor[0]); // Código do material
                    $nomeItem = mysqli_real_escape_string($con, $valor[1]); // Nome do item
                    $estoqSAP = mysqli_real_escape_string($con, $valor[2]); // Estoque SAP
                    $unidadeMedida = mysqli_real_escape_string($con, $valor[3]); // Unidade de medida
                    $locacaoMaterial = mysqli_real_escape_string($con, $valor[4]); // Unidade de medida
                    $depositoMaterial = mysqli_real_escape_string($con, $valor[5]); // Unidade de medida
                    $valorUnitario = mysqli_real_escape_string($con, $valor[6]); // Valor unitário
                    $valorTotal = mysqli_real_escape_string($con, $valor[7]); // Valor total

                    // Verifica se o material já existe no banco de dados
                    $checkQuery = mysqli_query($con, "SELECT * FROM `tb_inventario` WHERE `col_codMaterial` = '$codMaterial'");
                    if (mysqli_num_rows($checkQuery) > 0) {
                        echo "<h1>Material com código $codMaterial já existe no banco de dados. Pulando inserção.</h1>";
                        continue; // Pula para a próxima iteração do loop
                    }

                    // Se o material não existir, proceda com a inserção
                    $insertQuery = "INSERT INTO `tb_inventario` (`col_codMaterial`, `col_descMaterial`, `col_estoqSAP`, `col_unidMedida`, `col_locaDeposito`, `col_depositoMaterial`, `col_valorUnitario`, `col_valorTotal`, `col_status`, `col_digitadores`, `col_dataImportacao`) VALUES ('$codMaterial', '$nomeItem', '$estoqSAP', '$unidadeMedida','$locacaoMaterial', '$depositoMaterial', '$valorUnitario', '$valorTotal', '0', NULL, NOW())";
                    //var_dump($insertQuery);
                    $qr = mysqli_query($con, $insertQuery);

                    // Verifica se a consulta foi bem-sucedida
                    if ($qr) {
                        echo "<h1>Material com código $codMaterial inserido com sucesso no banco de dados!</h1>";
                    } else {
                        echo "<h1> ERRO AO INSERIR MATERIAL COM CÓDIGO $codMaterial NO BANCO DE DADOS! </h1>";
                    }
                }
                fclose($arquivo); // Fecha o arquivo após a leitura
            } else {
                echo "<h1> ERRO AO ABRIR O ARQUIVO! </h1>";
            }
            mysqli_close($con); // Fecha a conexão com o banco de dados
        }
        ?>
        <!-- Adicione um botão de voltar -->
        <button type="button" onclick="window.history.back()">Voltar</button>
    </div>
</body>

</html>