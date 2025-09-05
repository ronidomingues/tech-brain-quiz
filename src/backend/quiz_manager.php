<?php
// Inicia uma sessão;
session_start();
// Verifica se o formulário foi enviado corretamente e caso afirmativo, armazena os dados na sessão e cria variáveis necessárias;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aqui estou verificando se as devidas váriáveis, necessárias para essa execução, foram enviadas pelo formulário;
    if (isset($_POST['name']) && isset($_POST['difficulty']) && isset($_POST['idioms']) && isset($_POST['percentage'])) {
        $pl_name = trim($_POST['name']) ?? 'Player'; // Nome do jogador, padrão 'Player' se não fornecido;
        $difficulty = trim($_POST['difficulty']) ?? 'aleatory'; // Dificuldade escolhida, padrão 'aleatory' se não fornecido;
        $idioms = trim($_POST['idioms']) ?? 'pt_br'; // Define o idioma, padrão 'pt_br' se não fornecido;
        $percentage = floatval(str_replace(',', '.', $_POST['percentage'])) ?? 1.0; // Define a porcentagem de perguntas, padrão 100% se não fornecido;
        $_SESSION['player'] = $pl_name; // Armazena o nome do jogador na sessão;
        $_SESSION['difficulty'] = $difficulty; // Armazena a dificuldade escolhida na sessão;
        $_SESSION['idioms'] = $idioms; // Armazena o idioma escolhido na sessão;
        $_SESSION['lives'] = 3; // Define o número inicial de vidas;
        $_SESSION['score'] = 0; // Define a pontuação inicial;
        $_SESSION['current_question'] = 0; // Define a questão atual;
        $_SESSION['feedback'] = ''; // Define o feedback inicial Acerto ou erro;
        $_SESSION['explanation'] = ''; // Define a explicação que será mostrada ao jogador;
        $_SESSION['idioms'] = $idioms; // Armazena o idioma escolhido na sessão;
        $_SESSION['btn_send_answer'] = true; // Define se o botão de enviar resposta deve ser mostrado ou não;
        $_SESSION['errors'] = 0; // Define o número de erros cometidos pelo usúario durante as tentativas;
        $_SESSION['attempts'] = 1; // Define o número de tentativas realizadas pelo jogador;

        // Verifica o idioma escolhido e inclui o arquivo de perguntas correspondente;
        if ($idioms === 'pt_br') {
            $includes = '/../data/questions/questions_pt_br.php';
        } else {
            $includes = '/../data/questions/questions_en_us.php';
        }

        include_once(__DIR__.$includes);

        // Verificando se $percentage é um número entre 0 e 1;
        if (!is_numeric($percentage) || $percentage < 0 || $percentage >> 1.0) {
            $percentage = 1.0;
        }
        $_SESSION['percentage'] = $percentage; // Armazena a porcentagem de perguntas na sessão;

        // APENAS UMA OBSERVAÇÃO DAQUI PARA BAIXO: TENHO A CONSCIENCIA DE QUE O ARRAY QUE EU PREPAREI TEM EXATAMENTE O MESMO NÚMERO DE PERGUNTAS PARA CADA NÍVEL DE DIFICULDADE, PORÉM
        // ESTOU FAZENDO O CÓDIOIGO COM VERIFICAÇÕES COMO SE FOSSE UM CENÁRIO REAL, ONDE EU NÃO TERIA CONTROLE SOBRE A QUANTIDADE DE PERGUNTAS EM CADA NÍVEL DE DIFICULDADE.
        // ISSO PARA QUE EU POSSA TER UM CÓDIGO MAIS ROBUSTO E QUE POSSA SER REUTILIZADO EM OUTROS CENÁRIOS.
        // Calculando o número de perguntas com base na quantidade de perguntas disponíveis em cada nível de dificuldade;
        // Estou tomando 40% do total de perguntas disponíveis em cada nível de dificuldade;
        $percent_to_do_easy = round($percentage * count($questions['easy']));//51 ao todo;
        $percent_to_do_medium = round($percentage * count($questions['medium']));// 50 ao todo;
        $percent_to_do_hard = round($percentage * count($questions['hard']));// 52 ao todo;

        // Vou fazer uma verificação de segurança para garantir que o número de perguntas não seja menor que 1 e esteja dentro do limite disponível em cada nível de dificuldade;
        if ((1 < $percent_to_do_easy && $percent_to_do_easy < count($questions['easy'])) && (1 < $percent_to_do_medium && $percent_to_do_medium < count($questions['medium'])) && (1 < $percent_to_do_hard && $percent_to_do_hard < count($questions['hard']))) {
            // Se verificado que está dentro do limite de questões, posso começar a sortear os indices das questões;
            // Estou pegando um range de 0 até o total de perguntas menos 1 (menos um pois o array começa em 0), em seguida estou embaralhando esses números
            // Tive de fazer separado pois a função shuffle() retorna apenas um booleano e não o array embaralhado;
            $total_indexes_easy_aleatory = range(0, count($questions['easy']) - 1);
            shuffle($total_indexes_easy_aleatory);
            $total_indexes_medium_aleatory = range(0, count($questions['medium']) - 1);
            shuffle($total_indexes_medium_aleatory);
            $total_indexes_hard_aleatory = range(0, count($questions['hard']) - 1);
            shuffle($total_indexes_hard_aleatory);
            // E por fim estou pegando a quantidade de perguntas que o jogador irá responder, baseado na dificuldade escolhida;
            $indices_easy = array_slice($total_indexes_easy_aleatory, 0, $percent_to_do_easy);
            $indices_medium = array_slice($total_indexes_medium_aleatory, 0, $percent_to_do_medium);
            $indices_hard = array_slice($total_indexes_hard_aleatory, 0, $percent_to_do_hard);

            // Agora vou criar um novo array que vai conter as perguntas que o jogador irá responder, baseado na dificuldade escolhida;
            $selected_questions = [];
            if ($difficulty === 'easy') {
                foreach ($indices_easy as $index) {
                    $selected_questions[] = $questions['easy'][$index];
                }
            } elseif ($difficulty === 'medium') {
                foreach ($indices_medium as $index) {
                    $selected_questions[] = $questions['medium'][$index];
                }
            } elseif ($difficulty === 'hard') {
                foreach ($indices_hard as $index) {
                    $selected_questions[] = $questions['hard'][$index];
                }
            } else { // aleatory
                // Para as questões aleatórias, vou pegar 20 questões de cada nível de dificuldade, obtendo um total de 60 questões no array to_aleatory, dessas irei sortear 20 questões para o jogador responder;
                $to_aleatory = [];
                foreach ($indices_easy as $index) {
                    $to_aleatory[] = $questions['easy'][$index];
                }
                foreach ($indices_medium as $index) {
                    $to_aleatory[] = $questions['medium'][$index];
                }
                foreach ($indices_hard as $index) {
                    $to_aleatory[] = $questions['hard'][$index];
                }
                // Agora vou embaralhar o array to_aleatory;
                shuffle($to_aleatory);
                $_SESSION['to_aleatory'] = $to_aleatory;
                $n_first = round($percentage * count($to_aleatory));
                $selected_questions = array_slice($to_aleatory, 0, $n_first);
            }
            // Armazeno as perguntas selecionadas na sessão;
            $_SESSION['questions'] = $selected_questions;


        } else {
            // Caso o número de perguntas calculado esteja fora do limite, defino o número de perguntas como 1 para cada nível de dificuldade;
            // O programa retorna para a página inicial, pois não há perguntas suficientes para o quiz;
            // E armazeno uma mensagem de erro;
            $_SESSION['error'] = 'Não há perguntas suficientes para o quiz.';
            // Chama o Debbugger;
            header("Location: debug.php");
            // Retorno para a página inicial;
            //header("Location: index.php");
            //exit();
        }

        header("Location: /quiz.php");
        exit();
    } 
    // Estou agora verificando a passagem da variável alternatives, que armazena as alternativas escolhidas pelo jogador, a partir da passagem dela ocorrerão novas ações;
    if (isset($_POST['alternative'])) {
        // Recuperando o valor da alternativa escolhida pelo jogador;
        $alternative_selected = $_POST['alternative'];
        // Recuperando a resposta correta da pergunta atual;
        $correct_answer = $_SESSION["questions"][$_SESSION['current_question']]['answer'];

        // Desabilitando o botão de enviar resposta;
        $_SESSION['btn_send_answer'] = false;

        // Verificando se a resposta escolhida pelo jogador é a mesma da pergunta atual;
        if ($alternative_selected === $correct_answer) {
            // Armazeno o feedback e a explicação da pergunta atual na sessão;
            $_SESSION['feedback'] = '🎉 Parabéns '. $_SESSION['player'].'! Você acertou ✅. <br>';
            $_SESSION['explanation'] = '🧑‍🎓 Pois: '.$_SESSION['questions'][$_SESSION['current_question']]['explanation'];
            // Armazeno a pontuação do jogador na sessão;
            $_SESSION['score'] += 1;
        } else {
            // Armazeno o feedback e a explicação da pergunta atual na sessão;
            $_SESSION['feedback'] = '🤦‍♂️ Que pena '.$_SESSION['player'].'! Sua resposta foi incorreta. ❌ <br>';
            $_SESSION['explanation'] = "🧑‍🎓 : ".$_SESSION['questions'][$_SESSION['current_question']]['explanation'];
            // Armazeno a "Des-pontuação" do jogador na sessão;
            $_SESSION['errors'] += 1;
            // Armazeno a vida do jogador na sessão;
            $_SESSION['lives'] -= 1;
        }

        // Chama a página do quiz novamente;
        header("Location: /quiz.php");
    }
    // Estou agora verificando a passagem da variável next_question, que armazena o botão "Proxima Questão", a partir da passagem dela ocorrerão novas ações;
    if (isset($_POST["next_question"])){
        // Avança para a próxima pergunta;
        $_SESSION['current_question'] += 1;
        // Habilita o botão de enviar resposta;
        $_SESSION['btn_send_answer'] = true;
        // Chama a página do quiz novamente;
        header("Location: /quiz.php");
    }
    // Estou agora verificando a passagem da variável restart_quiz, que armazena o botão "Reiniciar Quiz", a partir da passagem dela ocorrerão novas ações;
    if (isset($_POST["restart_quiz"])){
        // Reseta o quiz para a primeira pergunta novamente;
        $_SESSION['current_question'] = 0;
        // Redefine as vidas do jogador;
        $_SESSION['lives'] = 3;
        // Adiciona uma tentativa ao jogador;
        $_SESSION['attempts'] += 1;
        // Habilita o botão de enviar resposta;
        $_SESSION['btn_send_answer'] = true;
        // Chama a página do quiz novamente;
        header("Location: /quiz.php");
    }
    // Estou agora verificando a passagem da variável back_to_menu, que armazena o botão "Voltar ao Menu", a partir da passagem dela ocorrerão novas ações;
    if (isset($_POST["back_to_menu"])){
        // Limpa todas as variáveis da sessão;
        session_unset();
        // Destroi a sessão;
        session_destroy();
        // Chama a página do menu novamente;
        header("Location: /index.php");
    }
}
?>