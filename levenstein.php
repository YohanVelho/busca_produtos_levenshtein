<?php 
$produtos = [
    ['nome' => 'Detergente', 'slug' => 'detergente'],
    ['nome' => 'Desinfetante', 'slug' => 'desinfetante'],
    ['nome' => 'Água Sanitária', 'slug' => 'agua-sanitaria'],
    ['nome' => 'Lustra Móveis', 'slug' => 'lustra-moveis'],
    ['nome' => 'Sabão em Pó', 'slug' => 'sabao-em-po'],
    ['nome' => 'Sabão Líquido', 'slug' => 'sabao-liquido'],
    ['nome' => 'Amaciante', 'slug' => 'amaciante'],
    ['nome' => 'Alvejante', 'slug' => 'alvejante'],
    ['nome' => 'Limpa Vidros', 'slug' => 'limpa-vidros'],
    ['nome' => 'Multiuso', 'slug' => 'multiuso'],
    ['nome' => 'Limpador de Piso', 'slug' => 'limpador-de-piso'],
    ['nome' => 'Limpador Perfumado', 'slug' => 'limpador-perfumado'],
    ['nome' => 'Desengordurante', 'slug' => 'desengordurante'],
    ['nome' => 'Limpa Banheiro', 'slug' => 'limpa-banheiro'],
    ['nome' => 'Limpador de Cozinha', 'slug' => 'limpador-de-cozinha'],
    ['nome' => 'Limpador de Inox', 'slug' => 'limpador-de-inox'],
    ['nome' => 'Saponáceo', 'slug' => 'saponaceo'],
    ['nome' => 'Cloro', 'slug' => 'cloro'],
    ['nome' => 'Limpador de Carpetes', 'slug' => 'limpador-de-carpetes'],
    ['nome' => 'Esponja de Aço', 'slug' => 'esponja-de-aco'],
    ['nome' => 'Esponja Multiuso', 'slug' => 'esponja-multiuso'],
    ['nome' => 'Pano de Limpeza', 'slug' => 'pano-de-limpeza'],
    ['nome' => 'Escova de Limpeza', 'slug' => 'escova-de-limpeza'],
    ['nome' => 'Borrifador', 'slug' => 'borrifador'],
    ['nome' => 'Vassoura', 'slug' => 'vassoura'],
    ['nome' => 'Rodo', 'slug' => 'rodo'],
    ['nome' => 'Álcool em Gel', 'slug' => 'alcool-em-gel'],
    ['nome' => 'Álcool Líquido', 'slug' => 'alcool-liquido'],
    ['nome' => 'Lava Roupas', 'slug' => 'lava-roupas'],
    ['nome' => 'Desodorizador de Ambientes', 'slug' => 'desodorizador-de-ambientes'],
];


$produto_busca = $_GET['busca'] ?? '';
$retorno = [];
$produto_econtrado = [];

if($produto_busca){
    
    $encontrado = '';

    // Se distancia negativa quer dizer que a distancia entre as duas strings é maior 255
    $distancia = -1;
    
    foreach($produtos as $produto){

        // Quanto mais proximo de zero mais identica é a string
        $maisProximoNome = levenshtein($produto['nome'], $produto_busca, 1, 2, 1);

        // Converte a busca em slug
        $produto_busca_slug = strtolower(str_replace(' ', '-', $produto_busca));

        $maisProximoSlug = levenshtein($produto['slug'], $produto_busca_slug, 1, 2, 1);
    
        // Verifico se o produto do array é igual ao produto da busca.
        if($maisProximoNome === 0){
            $encontradoNome = $produto['nome'];
            $encontradoSlug = $produto['slug'];
            $distancia = 0;
            $origem = 'nome';
            break;
        }

        // Verifico se o produto do array é igual ao slug da busca.
        if($maisProximoSlug === 0){
            $encontradoNome = $produto['nome'];
            $encontradoSlug = $produto['slug'];
            $distancia = 0;
            $origem = 'slug';
            break;
        }
    
        // Se o produto do array não for exato começo a comparar se ele é mais próximo que o produto comparado anteriormente.
        if($maisProximoNome <= 5 && $distancia != 0){
    
            // Se der verdadeiro o produto será guardado
            $encontradoNome = $produto['nome'];
            $encontradoSlug = $produto['slug'];
    
            // E defino o valor levenshtein do produto como o mais próximo. Este valor será utilizado nas comparações seguintes.
            $distancia = $maisProximoNome;
            $origem = 'nome';
        }

        // Se o slug produto do array não for exato começo a comparar se ele é mais próximo que que o slug comparado anteriormente.
        if($maisProximoSlug < $distancia && $distancia != 0){
    
            // Se der verdadeiro o produto será guardado
            $encontradoNome = $produto['nome'];
            $encontradoSlug = $produto['slug'];
    
            // E defino o valor levenshtein do produto como o mais próximo. Este valor será utilizado nas comparações seguintes.
            $distancia = $maisProximoSlug;
            $origem = 'slug';
        }
    }

    $retorno = [
        'distancia' => $distancia,
        'produto' => $encontradoNome,
        'slug' => $encontradoSlug,
        'origem' => $origem
    ];
}    

$produto_econtrado = $retorno;

echo '<pre>';
var_dump($retorno);
echo '</pre>';
