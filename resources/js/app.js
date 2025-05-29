import './bootstrap';

import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import AOS from 'aos';
import 'aos/dist/aos.css';

window.Swal = Swal;
window.Alpine = Alpine;

AOS.init();
Alpine.start();
