<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Leaflet Routing Example</title>
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
    <script>
        // Create map
        const map = L.map('map').setView([7.1907, 125.4553], 13);

        // Base map (OpenStreetMap)
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Example coordinates (Davao City → Panabo City)
        const start = L.latLng(7.1907, 125.4553); // Davao
        const end = L.latLng(7.3081, 125.6845); // Panabo

        // Routing control
        L.Routing.control({
            waypoints: [start, end],
            routeWhileDragging: true
        }).addTo(map);
    </script>
</body>

</html>