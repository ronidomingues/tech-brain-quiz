<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechBrain Quiz</title>
    <link rel="stylesheet" href="./assets/styles/index.css">
    <script src="./assets/scripts/particles.min.js" defer></script>
    <script src="./assets/scripts/particles_config.js" defer></script>
    <link rel="icon" type="image/x-icon" href="./assets/img/video_game.ico">
</head>
<body>
    <div id="particles-js"></div>
    <div class="container">
        <div class="header-section">
            <h1>TechBrain Quiz: O Desafio Começa</h1>
            <p class="tagline">Preparado para provar seu conhecimento? Seu cérebro é a sua ferramenta mais poderosa. Use-a.</p>
        </div>
        <div class="content-wrapper">
            <div class="instructions">
                <h2 class="instructions-title">📋 Regras do Jogo</h2>
                <div class="rule">
                    <div class="rule-icon">💗</div>
                    <div class="rule-content">
                        <strong>3 vidas</strong> - Cada erro custa uma vida. Quando suas vidas acabarem, o jogo reinicia.
                    </div>
                </div>
                <div class="rule">
                    <div class="rule-icon">🎯</div>
                    <div class="rule-content">
                        <strong>Um único objetivo</strong> - Demonstrar seu conhecimento em hardware e software.
                    </div>
                </div>
                <div class="rule">
                    <div class="rule-icon">🔁</div>
                    <div class="rule-content">
                        <strong>Observe as respostas</strong> - Mesmo ao errar, você aprenderá com as explicações fornecidas.
                    </div>
                </div>
                <div class="difficulty-levels">
                    <h3 class="difficulty-title">🎚️ Níveis de Dificuldade</h3>
                    
                    <div class="level">
                        <span class="level-name">Fácil:</span>
                        <span class="level-desc">Questões introdutórias para iniciantes</span>
                    </div>
                    
                    <div class="level">
                        <span class="level-name">Médio:</span>
                        <span class="level-desc">Conhecimento intermediário para entusiastas</span>
                    </div>
                    
                    <div class="level">
                        <span class="level-name">Difícil:</span>
                        <span class="level-desc">A prova final para experts em tecnologia</span>
                    </div>
                    
                    <div class="level">
                        <span class="level-name">Aleatório:</span>
                        <span class="level-desc">Uma mistura de todos os níveis - o desafio completo</span>
                    </div>
                </div>
            </div>
            <div class="form-initial">
                <form action="./api/call_quiz_manager.php" method="POST">
                    <label for="name">Digite seu nome:</label>
                    <input type="text" id="name" name="name" required>
                
                    <label for="difficulty">Escolha a dificuldade:</label>
                    <select name="difficulty" id="difficulty" required>
                        <option value="aleatory" selected>Aleatório</option>
                        <option value="easy">Fácil</option>
                        <option value="medium">Médio</option>
                        <option value="hard">Difícil</option>
                    </select>
                
                    <label for="percentage">Escolha a porcentagem de questões que você deseja responder:</label>
                    <select name="percentage" id="percentage" required>
                        <option value="0.2">20%</option>
                        <option value="0.25">25%</option>
                        <option value="0.3">30%</option>
                        <option value="0.35">35%</option>
                        <option value="0.4" selected>40%</option>
                        <option value="0.45">45%</option>
                        <option value="0.5">50%</option>
                        <option value="0.55">55%</option>
                        <option value="0.6">60%</option>
                        <option value="0.65">65%</option>
                        <option value="0.7">70%</option>
                        <option value="0.75">75%</option>
                        <option value="0.8">80%</option>
                        <option value="0.85">85%</option>
                        <option value="0.9">90%</option>
                        <option value="0.95">95%</option>
                        <option value="1.0">100%</option>
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
        </div>
    </div>
</body>
</html>