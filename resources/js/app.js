import './bootstrap';

import Alpine from 'alpinejs';
import { createGrowthChart } from './chart-config';

window.Alpine = Alpine;
window.createGrowthChart = createGrowthChart;

Alpine.start();
