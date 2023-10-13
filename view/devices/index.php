<?php

use yii\helpers\Html;

// Include Leaflet CSS and JavaScript from CDN
$this->registerCssFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', ['integrity' => 'sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=', 'crossorigin' => '']);
$this->registerJsFile('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['integrity' => 'sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=', 'crossorigin' => '']);

$this->title = 'Devices Map';
$this->params['breadcrumbs'][] = $this->title;

// Создаем массив для хранения данных о маркерах
$markers = [];

foreach ($devices as $device) {
    // Добавляем информацию о каждом устройстве в массив маркеров
    $markers[] = [
        'latitude' => $device->latitude,
        'longitude' => $device->longitude,
    ];
}

// Преобразуем массив маркеров в JSON для передачи в JavaScript
$markersJson = json_encode($markers);

$this->registerJs("
    var markers = $markersJson;

    function initMap() {
        var map = L.map('map').setView([51.505, -0.09], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        for (var i = 0; i < markers.length; i++) {
            var marker = L.marker([markers[i].latitude, markers[i].longitude]).addTo(map);
            marker.bindPopup(markers[i].info);
        }
    }

    initMap();
");
?>

<div id="map" style="width: 100%; height: 800px;"></div>
