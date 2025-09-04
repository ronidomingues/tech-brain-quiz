<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechBrain Quiz</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>TechBrain Quiz: O Desafio Começa.</h1>
    <p>Preparado para provar seu conhecimento? Seu cérebro é a sua ferramenta mais poderosa. Use-a.</p>
    <span>
        3 vidas e um único objetivo: o conhecimento. Erros fazem a jornada recomeçar, então observe as respostas para dominar o jogo. <br>
        <br>
        **Escolha seu nível:** <br>
        **Fácil:** Questões introdutórias. <br>
        **Médio:** Conhecimento intermediário. <br>
        **Difícil:** A prova final. <br>
        **Aleatório:** O desafio completo. <br>
        Boa sorte, você vai precisar.
    </span>
    <div class="form-initial">
        <form action="backend.php" method="POST">
            <label for="name">Digite seu nome:</label>
            <input type="text" id="name" name="name" required>
            <label for="difficulty">Escolha a dificuldade:</label>
            <select name="difficulty" id="difficulty" required>
                <option value="aleatory" selected>Aleatório</option>
                <option value="easy">Fácil</option>
                <option value="medium">Médio</option>
                <option value="hard">Difícil</option>
            </select>
            <label for="idioms">Escolha o idioma das perguntas:</label>
            <select name="idioms" id="idioms" required>
                <option value="pt_br" selected>Português (Brasil)</option>
                <option value="en_us">Inglês (EUA)</option>
            </select>
            <button type="submit">Iniciar Quiz</button>
            <button type="reset">Limpar Escolhas</button>
        </form>
    </div>
</body>
</html>