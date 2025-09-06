<?php
// Recupera os dados do jogador e armazena na sessão;
session_start();
// header serve para informar ao navegador qual o tipo de conteúdo que será renderizado na página;
header('Content-Type: text/html; charset=utf-8');
?>
<!-- A partir daqui estou renderizando com html a página de interação entre o quiz e o jogador; -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Aqui faço o titulo da página escrever o primeiro nome do jogador convertendo a primeira letra em maiúscula caso não esteja;
     explode serve para separar os nomes do jogador; semelhante ao split do python; -->
    <title><?= ucfirst(explode(" ", $_SESSION['player'])[0]); ?> - TechBrain Quiz</title>
    <link rel="stylesheet" href="./assets/styles/quiz.css">
    <link rel="icon" type="image/x-icon" href="./assets/img/robot_face.ico">
    <script src="./assets/scripts/particles.min.js" defer></script>
    <script src="./assets/scripts/particles_config.js" defer></script>
</head>
<body>
    <div id="particles-js"></div>
    <div class="container">
        <!-- Aqui estou definindo que se a questão atual for menor ou igual ao total de questões para o jogador, então elas serão renderizadas, caso contrário, será renderizado
        o placar final; -->
        <?php if($_SESSION["current_question"] <= count($_SESSION['questions']) - 1) { ?>
            <!-- Aqui estou escrevendo o nome do jogador; -->
            <div class="box">
                <h1><?php
                    if ($_SESSION['idioms'] === 'pt_br') {
                        echo "Olá, ".ucfirst(explode(" ", $_SESSION['player'])[0])." bem-vindo ao TechBrain Quiz, boa sorte!! <br>";
                    } elseif ($_SESSION['idioms'] === 'en_us') {
                        echo "Hi, " . ucfirst(explode(" ", $_SESSION['player'])[0]) . " welcome to TechBrain Quiz, good luck!! <br>";
                    }
                    ?>
                </h1>
                <div class="stats">
                    <!-- Aqui estou renderizando o Score atual, os erros e a vida atual; -->
                    <div class="stat-item">🎉: Acertos =  <?= $_SESSION['score']; ?></div>
                    <div class="stat-item">💔: Erros =  <?= $_SESSION['errors']; ?></div>
                    <div class="stat-item">💗: Vidas = <?= $_SESSION['lives']; ?></div>
                </div>

                <h4><!-- Aqui estou escrevendo a questão atual e o total de questões; -->
                    <?php if ($_SESSION['idioms'] === 'pt_br') { ?>
                        Questão <?= $_SESSION['current_question']; ?> de <?= count($_SESSION['questions']); ?>
                    <?php } elseif ($_SESSION['idioms'] === 'en_us') { ?>
                        Question <?= $_SESSION['current_question']; ?> of <?= count($_SESSION['questions']); ?>
                    <?php } ?>
                </h4>
                <!-- Aqui estou renderizando o emogi e a questão atual; -->
                <?php if ($_SESSION['lives'] !== 0 && $_SESSION['btn_send_answer']) { ?>
                    <p class="question"><strong><?= $_SESSION['questions'][$_SESSION['current_question']]['emoji'] . "  " . $_SESSION['questions'][$_SESSION['current_question']]['question']; ?></strong></p>
                <?php }?>
                <!-- Aqui crio um novo formulário, pois será necessário enviar a resposta dele para o backend para conferir se ela esta correta; -->
                <form action="./api/call_quiz_manager.php" method="POST">
                    <!-- Aqui vou colocar um condicional para mostrar ou não as alternativas do formulario juntamente com o botão de enviar a resposta; -->
                    <?php if ($_SESSION['btn_send_answer'] && $_SESSION['lives'] > 0) { ?>
                        <?php foreach ($_SESSION['questions'][$_SESSION['current_question']]['alternatives'] as $key => $alternative) { ?>
                            <label class="alternative">
                                <input type="radio" name="alternative" value="<?= $key; ?>" required><?= $alternative; ?><br>
                            </label>
                        <?php } ?>
                        <input type="submit" value="Confirmar Resposta">
                    <?php } elseif (!$_SESSION['btn_send_answer'] && $_SESSION['lives'] > 0) { ?>
                        <p>
                            <?= $_SESSION['feedback']. $_SESSION['explanation']; ?>
                        </p>
                        <input type="submit" value= <?= $_SESSION["current_question"] === count($_SESSION['questions']) - 1 ? "Finalizar Quiz" : "Próxima Questão"; ?> name="next_question"> <?php }
                    ?>
                    <?php if ($_SESSION['lives'] === 0) { ?>
                        <p> Poxa, você não tem mais vidas! Por favor reinicie o quiz.</p>
                        <span> Sua pontuação e seus erros serão mantidos, mas terá de recomeçar o quiz.</span> <br>
                        <input type="submit" value="Reiniciar Quiz" name="restart_quiz">
                    <?php } ?>
                </form>
                <form action="./api/call_quiz_manager.php" method="POST">
                    <input type="submit" value="Desistir e sair" name="back_to_menu">
                </form>
            </div>
        <?php } else { ?>
            <div class="box compact-box center-content">
                <!-- Aqui estou renderizando o placar final; -->
                <!-- Aqui estou escrevendo o nome do jogador e o placar final;
                Uso aqui nessa linha e usarei mais a frente uma coisa chamada de operador ternário, que serve para escrever uma coisa ou outra dependendo de uma condição
                como aqui (echo $_SESSION['errors'] === 1 ? '' : 's';) -->
                <h1>🎉 Parabéns <?= $_SESSION['player']; ?>! Seu placar final foi de: <?= $_SESSION['score']; ?> acertos e <?= $_SESSION['errors']; ?> erro<?= $_SESSION['errors'] === 1 ? '' : 's'; ?>.</h1>
                <p>
                    Em <?= $_SESSION['attempts'] ?> tentativa<?= $_SESSION['attempts'] > 1 ? 's' : ''; ?>,
                    você acertou <?= $_SESSION['score']; ?> questões e <?= $_SESSION['errors'] !== 0 ? 'errou '.$_SESSION['errors'].' questões' : 'não errou nenhuma questão!' ; ?> <br>
                    Obrigado por participar do TechBrain Quiz!
                </p>
                <!-- Aqui estou renderizando o resumo da jogada em uma tabela; -->
                <p class="resume">Aqui está um resumo detalhado da sua jogada:</p>
                <div class="resume-score">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2">Resultados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Nome do Jogador</td> <td align="center"><?= $_SESSION['player']; ?></td></tr>
                            <tr><td>Total de Perguntas</td><td align="center"><?= count($_SESSION['questions']); ?></td></tr>
                            <tr><td>Idioma</td><td align="center"><?= $_SESSION['idioms'] == 'pt_br' ? 'Português' : 'English'; ?></tr>
                            <tr><td>Dificuldade</td><td align="center"><?= ucfirst($_SESSION['difficulty']); ?></td></tr>
                            <tr><td>Acertos</td><td align="center"><?= $_SESSION['score']; ?></td></tr>
                            <tr><td>Erros</td><td align="center"><?= $_SESSION['errors']; ?></td></tr>
                            <tr><td>Tentativas</td><td align="center"><?= $_SESSION['attempts']; ?></td></tr>
                            <tr><td>Total de vidas gastas tomando em conta as tentativas</td><td align="center"><?= $_SESSION['attempts'] * 3 - $_SESSION['lives'];  ?></td></tr>
                            <tr><td>Vidas restantes na rodada vencedora</th><td align="center"><?= $_SESSION['lives']; ?></td></tr>
                        </tbody>
                    </table>
                </div>
                <form action="./api/call_quiz_manager.php" method="POST">
                    <input type="submit" value="Finalizar e voltar ao menu" name="back_to_menu">
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>