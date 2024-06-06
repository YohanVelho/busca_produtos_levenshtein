<?php
    require "levenstein.php";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de produtos de limpeza com levenshtein</title>
</head>
<body>
    <div>
        <form action="" method="get">
            <input type="text" name="busca" value="<?= $_GET['busca'] ?? '' ?>">
            <button type="submit">Buscar</button>
        </form>
    </div>
    <?php if($produto_econtrado['distancia'] >= 0) :  ?>
        <div>
            <?php if($produto_econtrado['distancia'] === 0) : ?>
                <p>
                    Encontramos o produto: <?= $produto_econtrado['produto'] ?>
                </p>
            <?php else : ?>
                <p>
                    Você quis dizer: <a href="/?busca=<?= urlencode($produto_econtrado['produto']) ?>"><?= $produto_econtrado['produto'] ?></a> ? 
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body>
</html>