import L from 'leaflet';

export function displayRouteMap(containerId, routeData) {
    const mapElement = document.getElementById(containerId);
    if (!mapElement || !routeData || routeData.length === 0) return;

    // Clear any previous map instance from the container
    if (mapElement._leaflet_id) {
        mapElement._leaflet_id = null;
    }

    const map = L.map(containerId);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const polyline = L.polyline(routeData, {color: 'rgb(79 70 229)', weight: 5}).addTo(map);

    // Add start and end markers
    L.marker(routeData[0]).addTo(map).bindPopup('Start');
    L.marker(routeData[routeData.length - 1]).addTo(map).bindPopup('End');

    map.fitBounds(polyline.getBounds().pad(0.1));
}