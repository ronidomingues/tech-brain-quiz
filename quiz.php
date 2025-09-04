<?php session_start();
header('Content-Type: text/html; charset=utf-8');
?>
<!-- A partir daqui estou renderizando com html a página de interação entre o quiz e o jogador; -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Aqui faço o titulo da página escrever o nome do jogador; -->
    <title><?php echo $_SESSION['player']; ?> - TechBrain Quiz</title>
</head>
<body>
    <!-- Aqui estou escrevendo o nome do jogador e a questão atual; -->
    <h1><?php
        if ($_SESSION['idioms'] === 'pt_br') {
            echo "Bem-vindo ao TechBrain Quiz, " . $_SESSION['player'] . ", boa sorte!! Você está na questão " . $_SESSION['current_question'] + 1 . " de ". count($_SESSION['questions']);
        } elseif ($_SESSION['idioms'] === 'en_us') {
            echo "Welcome to the TechBrain Quiz, " . $_SESSION['player'] . ", good luck!! You're on question " . $_SESSION['current_question'] + 1 . " of " . count($_SESSION['questions']);
        }
        ?>
    </h1>
    <!-- Aqui estou renderizando o emogi e a questão atual; -->
    <p class="question"><strong><?php echo $_SESSION['questions'][$_SESSION['current_question']]['emoji'] . "  " . $_SESSION['questions'][$_SESSION['current_question']]['question']; ?></strong></p>
    <!-- Aqui crio um novo formulário, pois será necessário enviar a resposta dele para o backend para conferir se ela esta correta; -->
    <form action="backend.php" method="POST">
        <?php foreach ($_SESSION['questions'][$_SESSION['current_question']]['alternatives'] as $key => $alternative) { ?>
            <input type="radio" name="alternative" value="<?php echo $key; ?>"><?php echo $alternative; ?><br>
        <?php } ?>
        <input type="submit" value="Enviar">
    </form>
    <p><?php echo $_SESSION['feedback'] . $_SESSION['explanation']; ?></p>
</body>
</html>