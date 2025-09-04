# TechBrain Quiz

## Estrutura do Projeto

### Estrutura do array

Ambos os arrays `questions_pt_br.php` e `questions_en_us.php` foram dividido da seguinte forma: nivel de dificuldade, perguntas, alternativas, resposta, expllicação e um emogi para as respostas, é de extrema importância que o array seja mantido dessa forma (nessa estrutura), para que o sistema funcione corretamente. O array pode ser expandido ou reduzido e mudado o tema das questões, mas a estrutura deve ser mantida ou todo o software deve ser reescrito.

```php
$questions = [
    'easy' => [
        [
            'question' => 'Pergunta fácil 1',
            'alternatives' => [
                "a" => "Opção 1",
                "b" => "Opção 2",
                "c" => "Opção 3",
            ],
            'answer' => 0, // Índice da resposta correta
            'explanation' => 'Explicação da resposta fácil 1',
            'emoji' => '😊 '
        ],
        // Mais perguntas fáceis...
    ],
    'medium' => [
        [
            'question' => 'Pergunta média 1',
            'alternatives' => [
                "a" => "Opção 1",
                "b" => "Opção 2",
                "c" => "Opção 3",
            ],
            'answer' => 0, // Índice da resposta correta
            'explanation' => 'Explicação da resposta média 1',
            'emoji' => '😊 '
        ],
        // Mais perguntas médias...
    ],
    'hard' => [
        [
            'question' => 'Pergunta difícil 1',
            'alternatives' => [
                "a" => "Opção 1",
                "b" => "Opção 2",
                "c" => "Opção 3",
            ],
            'answer' => 0, // Índice da resposta correta
            'explanation' => 'Explicação da resposta difícil 1',
            'emoji' => '😊 '
        ],
        // Mais perguntas difíceis...
    ]
];
```
