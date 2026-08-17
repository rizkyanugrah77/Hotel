import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
import Swal from 'sweetalert2'
import { Chart } from 'chart.js/auto';
import { getRelativePosition } from 'chart.js/helpers';


Alpine.plugin(Clipboard)
window.Chart = Chart
window.getRelativePosition = getRelativePosition

Livewire.start()
