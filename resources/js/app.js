import './bootstrap';
import '../css/app.css';
import 'flowbite';

import.meta.glob([
    '../images/**',
    '../fonts/**',
]);

import { gsap } from "gsap";

import { CustomEase } from "gsap/CustomEase";
import { RoughEase, ExpoScaleEase, SlowMo } from "gsap/EasePack";

import { Flip } from "gsap/Flip";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { Observer } from "gsap/Observer";
import { ScrollToPlugin } from "gsap/ScrollToPlugin";
import { Draggable } from "gsap/Draggable";
import { MotionPathPlugin } from "gsap/MotionPathPlugin";
import { EaselPlugin } from "gsap/EaselPlugin";
import { PixiPlugin } from "gsap/PixiPlugin";
import { TextPlugin } from "gsap/TextPlugin";

window.gsap = gsap;
window.Draggable = Draggable;
window.Flip = Flip;
window.ScrollTrigger = ScrollTrigger;
window.Observer = Observer;
window.ScrollToPlugin = ScrollToPlugin;
window.Draggable = Draggable;
window.MotionPathPlugin = MotionPathPlugin;
window.EaselPlugin = EaselPlugin;
window.PixiPlugin = PixiPlugin;
window.TextPlugin = TextPlugin;

window.gsap.registerPlugin(Flip,ScrollTrigger,Observer,ScrollToPlugin,Draggable,MotionPathPlugin,EaselPlugin,PixiPlugin,TextPlugin,RoughEase,ExpoScaleEase,SlowMo,CustomEase);

import LocomotiveScroll from 'locomotive-scroll';

const locomotiveScroll = new LocomotiveScroll({
    el: document.querySelector('[data-scroll-container]'),
    smooth: true
});

