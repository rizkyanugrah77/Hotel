import './bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
import Swal from 'sweetalert2'



Alpine.plugin(Clipboard)

Livewire.start()

