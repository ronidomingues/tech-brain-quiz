particlesJS("particles-js", {
    "particles": {
        "number": {
            "value": 80,
            "density": { "enable": true, "value_area": 800 }
        },
        "color": { "value": "#00f0ff" },
        "shape": {
            "type": "polygon",
            "stroke": { "width": 0, "color": "#000" },
            "polygon": { "nb_sides": 6 }
        },
        "opacity": {
            "value": 0.5,
            "random": true,
            "anim": { "enable": true, "speed": 1, "opacity_min": 0.1, "sync": false }
        },
        "size": {
            "value": 3,
            "random": true,
            "anim": { "enable": false }
        },
        "line_linked": {
            "enable": true,
            "distance": 150,
            "color": "#00f0ff",
            "opacity": 0.4,
            "width": 1
        },
        "move": {
            "enable": true,
            "speed": 3,
            "direction": "none",
            "random": false,
            "straight": false,
            "out_mode": "out",
            "bounce": false
        }
        },
        "interactivity": {
            "detect_on": "window",                   // <- ESSENCIAL PARA O HOVER FUNCIONAR POR CIMA DO CONTEÚDO
            events: {
            onhover: { enable: true, mode: "repulse" }, // repulse no hover
            onclick: { enable: true, mode: "repulse" }, // repulse também no clique (opcional)
            resize: true
            },
            modes: {
            repulse: { distance: 150, duration: 0.4 },
            push: { particles_nb: 4 },
            grab: { distance: 200, line_linked: { opacity: 0.7 } },
            bubble: { distance: 180, size: 6, duration: 0.4, opacity: 0.8 }
        }
    },
    "retina_detect": true
});