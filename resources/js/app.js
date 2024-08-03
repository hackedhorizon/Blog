import './bootstrap';
import '../css/app.css';
import 'flowbite';

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import LocomotiveScroll from 'locomotive-scroll';

const locomotiveScroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true
});

window.locomotiveScroll = locomotiveScroll;
