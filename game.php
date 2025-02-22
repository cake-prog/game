<?php


class Hello
{
    public $level;

    public function rules()
    {
        echo "\n";
        // HEREDOC
        print <<<END
        Добро пожаловать в игру "Рандомное число"!
        Я загадаю число от 1 до 50.
        Тебе необходимо отгадать, какое число я загадал!!

        Пожалуйста, выбери уровень сложности:
        1. Простой (15 попыток)
        2. Средний (10 попыток)
        3. Сложный (5 попыток)
        END;
        echo "\n";
    }

    public function enterDifficultyLevel()
    {
        $this->level = readline('Введи номер уровня сложности: ');
    }
}

class Play extends Hello
{
    private $maxAttempts;

    public function setMaxAttempts()
    {
        switch ($this->level) {
            case '1':
                $this->maxAttempts = 15;
                break;
            case '2':
                $this->maxAttempts = 10;
                break;
            case '3':
                $this->maxAttempts = 5;
                break;
            default:
                echo 'Введите правильный уровень сложности.';
                echo "\n";
                exit;
        }
    }

    public function startGame()
    {
        $this->setMaxAttempts();
        $secretNumber = rand(1, 50);
        $attempts = 0;

        echo "Я загадал число от 1 до 50. У тебя есть $this->maxAttempts попыток, чтобы его отгадать!\n";

        while ($attempts < $this->maxAttempts) {
            $guess = readline('Введи своё число: ');
            $attempts++;

            if (!is_numeric($guess)) {
                echo "Пожалуйста, введи корректное число.\n";
                $attempts--; // Не считаем попытку при некоррект номере
                continue;
            }

            if ($guess < $secretNumber) {
                echo "Слишком мало! Попробуй еще раз.\n";
            } elseif ($guess > $secretNumber) {
                echo "Слишком много! Попробуй еще раз.\n";
            } else {
                echo "Поздравляю! Ты угадал число $secretNumber с $attempts попытки!\n";
                return;
            }
        }

        echo "К сожалению, ты исчерпал все попытки. Загаданное число было $secretNumber.\n";
    }
}

$user = new Hello();
$user->rules();
$user->enterDifficultyLevel();

$play = new Play();
$play->level = $user->level; // Передаем уровень сложности в объект Play
$play->startGame();