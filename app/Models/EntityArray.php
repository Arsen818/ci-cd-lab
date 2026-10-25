<?php
$categories = ['Сантехніка', 'Опалення', 'Електроніка', 'Кліматична техніка', 'Інструменти'];
sort($categories); 

$product = [
    'id' => 101,
    'sku' => 'WP-123',
    'name' => 'Котел Westen Pulsar D',
    'price' => 25000.50,
    'stock' => 12
];
?>

<h3>Категорії (відсортовані):</h3>
<ul>
    <?php foreach ($categories as $category): ?>
        <li><?= $category ?></li>
    <?php endforeach; ?>
</ul>

<h3>Інформація про товар:</h3>
<ul>
    <?php foreach ($product as $key => $value): ?>
        <li><strong><?= $key ?>:</strong> <?= $value ?></li>
    <?php endforeach; ?>
</ul>