<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Карта пунктов раздельного сбора | EcoBin</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map { 
            height: 100vh;
            width: 100%;
        }
        .point-info {
            padding: 10px;
            max-width: 300px;
        }
        .point-info h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .point-info p {
            margin: 5px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Главная</a>
        </nav>
    </header>

    <div class="container">
        <div id="map"></div>
    </div>

    <script>
        const userLocation = @json($userLocation);
        const recyclePoints = @json($recyclePoints);

        const map = L.map('map').setView([userLocation.lat, userLocation.lon], 12);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors',
            language: 'ru'
        }).addTo(map);

        recyclePoints.forEach(point => {
            const coords = point.geom.replace('POINT(', '').replace(')', '').split(' ');
            const marker = L.marker([coords[1], coords[0]]).addTo(map);
            
            const popupContent = `
                <div class="point-info">
                    <h3>${point.title}</h3>
                    <p><strong>Адрес:</strong> ${point.address}</p>
                    <p><strong>Принимает:</strong> ${point.fractions.map(f => f.name).join(', ')}</p>
                    ${point.businesHoursState.state === 'allday' ? 
                        '<p><strong>Время работы:</strong> Круглосуточно</p>' : 
                        ''}
                </div>
            `;
            
            marker.bindPopup(popupContent);
            
            marker.on('mouseover', function (e) {
                this.openPopup();
            });
        });
    </script>
</body>
</html>
