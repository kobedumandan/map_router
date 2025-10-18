<?php
require 'db_connect.php';
$dbconn = (new db_connect())->connect();

$q = $dbconn->prepare("SELECT * FROM locations");
$q->execute();
$q_result = $q->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map Router</title>
    <link rel="stylesheet" href="css/index-page.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin="" /> <!-- LeafletJS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <video autoplay muted loop id="bg-video">
        <source src="video/vid.mp4" type="video/mp4">

    </video>
    <div class="outermost_wrapper d-flex">

        <div class="content_panel pt-4 px-4">
            <div class="col docu_name_space d-flex justify-content-center p-2 mb-3">
                <div style="font-weight: bold; color:white;">Map Router</div>
            </div>
            <div class="col select_col d-flex align-items-center m-3">
    <!-- From -->
    <div class="from d-flex align-items-center">
        <div class="me-1 text-white">From:</div>
        <div class="dropdown">
            <a class="btn btn-danger btn-sm dropdown-toggle fixed-dropdown-btn"
                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown_from">
                --Select Location--
            </a>
            <ul class="dropdown-menu fixed-dropdown-menu" aria-labelledby="dropdown_from">
                <?php foreach ($q_result as $x): ?>
                    <li>
                        <a class="dropdown-item"
                            href="#"
                            data-id="<?= htmlspecialchars($x['loc_id']) ?>"
                            data-lat="<?= htmlspecialchars($x['lat']) ?>"
                            data-lng="<?= htmlspecialchars($x['lng']) ?>">
                            <?= htmlspecialchars($x['loc_name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <input type="hidden" name="select_from" id="select_from">

    <!-- To -->
    <div class="to d-flex align-items-center ms-3 me-4">
        <div class="me-1 text-white">To:</div>
        <div class="dropdown">
            <a class="btn btn-danger btn-sm dropdown-toggle fixed-dropdown-btn"
                href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="dropdown_to">
                --Select Location--
            </a>
            <ul class="dropdown-menu fixed-dropdown-menu" aria-labelledby="dropdown_to">
                <?php foreach ($q_result as $x): ?>
                    <li>
                        <a class="dropdown-item"
                            href="#"
                            data-id="<?= htmlspecialchars($x['loc_id']) ?>"
                            data-lat="<?= htmlspecialchars($x['lat']) ?>"
                            data-lng="<?= htmlspecialchars($x['lng']) ?>">
                            <?= htmlspecialchars($x['loc_name']) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <input type="hidden" name="select_to" id="select_to">

    <!-- Buttons (right-aligned) -->
    <div class="ms-auto">
        <button class="btn btn-warning btn-sm p-1 me-2 text-white"
            id="route_btn" onclick="findRoute()">
            <i class="bi bi-geo-alt"></i>
            Find Route
        </button>

        <button class="btn btn-success btn-sm p-1 me-3 text-white"
            id="add_loc_btn" data-bs-toggle="modal" data-bs-target="#pick_location_modal">
            <i class="bi bi-plus-square me-1"></i>
            Add Location
        </button>
    </div>
</div>
            <div class="col d-flex justify-content-center">
                <div id="map">
                </div>
            </div>
        </div>
    </div>

    <!-- Location Picker Modal -->
    <div class="modal modal-lg fade" id="pick_location_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pick Location</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <div id="map_loc_picker">
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <div class="coords">
                        <form id="locCoordinates" action="funcs/add_location.php" method="POST">
                            Lat: <input id="lat" name="loc_lat" size="12" readonly>
                            Lng: <input id="lng" name="loc_lng" size="12" readonly>
                            Name: <input id="loc_name" name="l_name" type="text" size="12" required>
                        </form>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="locCoordinates">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script> <!-- LeafletJS -->
    <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

    <script>
        // Main Map
        var map = L.map('map').setView([7.3081, 125.6845], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Map picker
        let loc_picker_marker = null;
        var picker = L.map('map_loc_picker').setView([7.1907, 125.4553], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(picker);

        // recalc tile layout after modal opens
        const locModal = document.getElementById('pick_location_modal');
        locModal.addEventListener('shown.bs.modal', () => {
            picker.invalidateSize();
        });

        picker.on('click', (e) => {
            const {
                lat,
                lng
            } = e.latlng;

            if (loc_picker_marker) {
                loc_picker_marker.setLatLng(e.latlng);
            } else {
                loc_picker_marker = L.marker(e.latlng, {
                    draggable: true
                }).addTo(picker);
                loc_picker_marker.on('dragend', (ev) => {
                    const p = ev.target.getLatLng();
                    updateUI(p.lat, p.lng, true);
                });
            }
            updateUI(lat, lng, true);
        })

        function updateUI(lat, lng, openPopup = false) {
            document.getElementById('lat').value = lat.toFixed(6);
            document.getElementById('lng').value = lng.toFixed(6);
            if (loc_picker_marker && openPopup) {
                loc_picker_marker.bindPopup(`${lat.toFixed(6)}, ${lng.toFixed(6)}`).openPopup();
            }
        }

        let lat1, lat2, lng1, lng2;
        let routingControl;

        document.querySelectorAll('#dropdown_from ~ .dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Update button text
                document.getElementById('dropdown_from').textContent = this.textContent;

                // Update hidden input
                document.getElementById('select_from').value = this.getAttribute('data-id');

                // Set coordinates
                lat1 = this.getAttribute('data-lat');
                lng1 = this.getAttribute('data-lng');
                console.log("FROM:", lat1, lng1);
            });
        });
        document.querySelectorAll('#dropdown_to ~ .dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();

                // Update button text
                document.getElementById('dropdown_to').textContent = this.textContent;

                // Update hidden input
                document.getElementById('select_to').value = this.getAttribute('data-id');

                // Set coordinates
                lat2 = this.getAttribute('data-lat');
                lng2 = this.getAttribute('data-lng');
                console.log("TO:", lat2, lng2);
            });
        });

        function findRoute() {
            if (lat1 && lng1 && lat2 && lng2) {
                var start = L.latLng(lat1, lng1);
                var end = L.latLng(lat2, lng2);

                // remove old route if it exists
                if (routingControl) {
                    map.removeControl(routingControl);
                }

                // create new route
                routingControl = L.Routing.control({
                    waypoints: [start, end],
                    routeWhileDragging: true
                }).addTo(map);

            } else {
                alert("Please select both start and destination first!");
            }
        }
    </script>
</body>

</html>