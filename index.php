<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importar Materiais</title>
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

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        input[type="file"] {
            margin-bottom: 10px;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <form action="funcao/processa.php" method="post" enctype="multipart/form-data">
        <input type="file" name="enviar_material" id="enviar_material" multiple="multiple">
        <button type="submit">Processar Materiais</button>
    </form>

    <form action="atualizacao_estoque.php" method="post" enctype="multipart/form-data">
        <input type="file" name="enviar_material" id="enviar_material" multiple="multiple">
        <button type="submit">Atualizar Estoque</button>
    </form>
</body>
</html>
