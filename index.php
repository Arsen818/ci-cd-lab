<?php

use Faker\Factory;

require_once 'vendor/autoload.php';
require_once 'app/Services/EntityService.php';
require_once 'app/Services/DataProcessor.php';

echo '<h2>Завдання 1: Масиви</h2>';
require_once 'app/Models/EntityArray.php';

echo '<h2>Завдання 2: Строга типізація</h2>';
$total = EntityService::calculateTotal(1250.00, 11);
echo "<p>Загальна вартість 11 товарів по 1250 грн: $total грн</p>";

echo '<h2>Завдання 3: Генерація даних (Faker) та фільтрація</h2>';
$faker = Factory::create();
$prices = [];
for ($i = 0; $i < 10; $i++) {
    $prices[] = $faker->randomFloat(2, 100, 5000);
}

$minThreshold = 2000;
$expensiveProducts = array_filter($prices, function ($price) use ($minThreshold) {
    return $price > $minThreshold;
});

echo '<p>Усі ціни: '.implode('; ', $prices).'</p>';
echo "<p>Ціни товарів вище $minThreshold грн: ".implode('; ', $expensiveProducts).'</p>';

echo '<h2>Завдання 4: Обробка винятків</h2>';
try {
    echo '<p>Спроба застосувати знижку 150% до товару...</p>';
    EntityService::applyDiscount(25000.50, 150);
} catch (Exception $e) {
    echo "<p style='color:red;'>Помилка: ".$e->getMessage().'</p>';
} finally {
    echo '<p>Завершення спроби розрахунку знижки.</p>';
}

echo '<h2>Завдання 5: Індивідуальне алгоритмічне завдання</h2>';

$numbers = [15, 42, 8, 99, 23];
echo '<p><strong>Таблиця 3.2:</strong> Вхідний масив [15, 42, 8, 99, 23] -> За спаданням: '.implode(', ', DataProcessor::sortDescending($numbers)).'</p>';

$str3 = 'Це система обліку для складу опалювального обладнання';
echo "<p><strong>Таблиця 3.3:</strong> 3 останні слова з '$str3' -> <em>".DataProcessor::getLastThreeWords($str3).'</em></p>';

$str4 = 'Система відвантажує терморегулятори клієнтам щодня';
echo "<p><strong>Таблиця 3.4:</strong> Оригінал: '$str4' <br> Результат: <em>".DataProcessor::shuffleMiddleWords($str4).'</em></p>';
