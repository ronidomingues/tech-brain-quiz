<?php
session_start();

// Debug: verificar tudo que está vindo no POST
echo "<h3>Debug do $_POST:</h3>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

// Debug: verificar toda a sessão
echo "<h3>Debug da Sessão:</h3>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['alternative']) && !empty($_POST['alternative'])) {
        $alternativa = $_POST['alternative'];
        echo "<h3>Sucesso!</h3>";
        echo "Alternativa recebida: " . htmlspecialchars($alternativa);
        
        // Verificar se existe na sessão
        if (isset($_SESSION['questions'][$_SESSION['current_question']]['alternatives'][$alternativa])) {
            echo "<br>Alternativa válida na sessão!";
        } else {
            echo "<br>Alternativa NÃO encontrada na sessão!";
        }
        
    } else {
        echo "<h3>Erro:</h3>";
        echo "Nenhuma alternativa foi selecionada ou o valor está vazio!";
    }
}
?>