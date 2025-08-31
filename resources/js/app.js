import './bootstrap';
import flatpickr from "flatpickr";
import "flatpickr/dist/flatpickr.min.css";
import 'leaflet/dist/leaflet.css';
import L from 'leaflet';
import Chart from 'chart.js/auto'; 
import { displayRouteMap } from './map-helpers.js';

window.Chart = Chart; 
window.displayRouteMap = displayRouteMap; // <-- AND ADD THIS LINE


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
