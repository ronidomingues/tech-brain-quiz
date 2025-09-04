<?php
// Inicia uma sessão;
session_start();
// Verifica se o formulário foi enviado corretamente e caso afirmativo, armazena os dados na sessão e cria variáveis necessárias;
if (isset($_POST['name']) && isset($_POST['difficulty']) && isset($_POST['idioms'])) {
    $pl_name = $_POST['name'] ?? 'Player'; // Nome do jogador, padrão 'Player' se não fornecido;
    $difficulty = $_POST['difficulty'] ?? 'aleatory'; // Dificuldade escolhida, padrão 'aleatory' se não fornecido;
    $idioms = $_POST['idioms'] ?? 'pt_br'; // Define o idioma, padrão 'pt_br' se não fornecido;
    $_SESSION['player'] = $pl_name; // Armazena o nome do jogador na sessão;
    $_SESSION['difficulty'] = $difficulty; // Armazena a dificuldade escolhida na sessão;
    $_SESSION['idioms'] = $idioms; // Armazena o idioma escolhido na sessão;
    $_SESSION['lives'] = 3; // Define o número inicial de vidas;
    $_SESSION['score'] = 0; // Define a pontuação inicial;
    $_SESSION['current_question'] = 0; // Define a questão atual;
    $_SESSION['feedback'] = ''; // Define o feedback inicial Acerto ou erro;
    $_SESSION['explanation'] = ''; // Define a explicação que será mostrada ao jogador;
    $_SESSION['idioms'] = $idioms;

    // Verifica o idioma escolhido e inclui o arquivo de perguntas correspondente;
    if ($idioms === 'pt_br') {
        $includes = 'questions_pt_br.php';
    } else {
        $includes = 'questions_en_us.php';
    }

    include_once($includes);

    // APENAS UMA OBSERVAÇÃO DAQUI PARA BAIXO: TENHO A CONSCIENCIA DE QUE O ARRAY QUE EU PREPAREI TEM EXATAMENTE O MESMO NÚMERO DE PERGUNTAS PARA CADA NÍVEL DE DIFICULDADE, PORÉM
    // ESTOU FAZENDO O CÓDIOIGO COM VERIFICAÇÕES COMO SE FOSSE UM CENÁRIO REAL, ONDE EU NÃO TERIA CONTROLE SOBRE A QUANTIDADE DE PERGUNTAS EM CADA NÍVEL DE DIFICULDADE.
    // ISSO PARA QUE EU POSSA TER UM CÓDIGO MAIS ROBUSTO E QUE POSSA SER REUTILIZADO EM OUTROS CENÁRIOS.
    // Calculando o número de perguntas com base na quantidade de perguntas disponíveis em cada nível de dificuldade;
    // Estou tomando 40% do total de perguntas disponíveis em cada nível de dificuldade;
    $percent_to_do_easy = round(0.4 * count($questions['easy']));
    $percent_to_do_medium = round(0.4 * count($questions['medium']));
    $percent_to_do_hard = round(0.4 * count($questions['hard']));

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
            // Agora vou embaralhar o array to_aleatory e pegar as primeiras 20 questões;
            shuffle($to_aleatory);
            $selected_questions = array_slice($to_aleatory, 0, 20);
        }
        // Armazeno as perguntas selecionadas na sessão;
        $_SESSION['questions'] = $selected_questions;


    } else {
        // Caso o número de perguntas calculado esteja fora do limite, defino o número de perguntas como 1 para cada nível de dificuldade;
        // O programa retorna para a página inicial, pois não há perguntas suficientes para o quiz;
        // E armazeno uma mensagem de erro;
        $_SESSION['error'] = 'Não há perguntas suficientes para o quiz.';
        header("Location: index.php");
        exit();
    }

    header("Location: quiz.php");
    exit();
}
?>