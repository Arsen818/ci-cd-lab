<?php

declare(strict_types=1);

require_once 'vendor/autoload.php';

use App\Core\Database;
use App\Core\EntityFactory;
use App\Services\ConsoleLogger;
use App\Services\EntityService;
use App\Tasks\Artist;
use App\Tasks\Car;
use App\Tasks\Genre;
use App\Tasks\Worker;

echo '<h3>1. Singleton:</h3>';
$db = Database::getInstance();
$db2 = Database::getInstance();

echo '<h3>2. Factory, DI та Трейт:</h3>';
$factory = new EntityFactory;
$product = $factory->createEntity('product', [
    'id' => '1', 'createdAt' => '2023-10-25', 'name' => 'Котел', 'price' => 25000,
]);

$logger = new ConsoleLogger;
$service = new EntityService($logger);
$service->processEntity($product);

echo '<br>Експорт JSON: '.$product->exportToJson().'<br>';

echo '<h3>3. Індивідуальні завдання:</h3>';

$genre = new Genre(1, 'Rock');
$artist = new Artist(1, 'The Beatles', true, 1960);
$genre->addArtist($artist);
echo "Жанр: {$genre->name}, Артистів: ".count($genre->getArtists()).'<br>';

$car = new Car(100);
echo 'Час авто на 200км: '.$car->calculateTravelTime(200).' год<br>';

$worker = new Worker(10000, 50, 200);
echo 'Зарплата працівника: '.$worker->calculateSalary().' грн<br>';
