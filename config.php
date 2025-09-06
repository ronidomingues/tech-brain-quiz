<?php
// Detectando se o usuário está rodando pelo servidor Embutido do PHP ou pelo Apache e
// definindo a URL base do projeto;
if (PHP_SAPI === 'cli-server'){
    define('BASE_URL', '');
} else {
    define('BASE_URL', '/tech-brain-quiz/public/');
}
?>