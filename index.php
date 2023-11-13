<?php

$seo_keywords = 'May-tricks, Matrix transformations, matrices, matrix, transformations, transformation, translation, rotation, enlargements, 3d, 3d matrix, 3d transformation, 3d transformations, stretch, shear';
$seo_description = "We're stuck in the matrix!";
$seo_author = 'Alex lo Storto';
$site_title = 'May-tricks';

$title = 'May-tricks';

include('./components/header.php');

?>

<style>
    * {
        margin: 0px;
        padding: 0px;
        font-family: 'Prompt', sans-serif;
    }

    body {
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background-color: var(--accent);
    }

    header {
        width: 100%;
    }

    header h1 {
        color: var(--secondary);
        text-shadow: 0 0 50px #B28DDE;
        padding: 2rem 3rem;
        padding-right: 1rem;
        margin: 0;
        font-size: 3rem;
        font-weight: 500;
    }

    main {
        padding: 2rem;
        gap: 2rem;
    }

    #controls,
    #canvas {
        border: 1px solid var(--secondary);
        box-shadow: 0 0 20px #B28DDE;
        border-radius: 20px;
    }

    #controls h2,
    #canvas h2 {
        padding: 1.25rem;
        font-weight: 200;
        color: var(--secondary);
        text-shadow: 0 0 50px var(--secondary);
    }

    #controls .matrix-transformation {
        position: relative;
        grid-template-rows: 1fr 1fr; /* Two equal rows */
        grid-template-columns: 1fr 1fr; /* Two equal columns */
        gap: 1rem; /* Adjust the gap between items as needed */
        margin: 0 2rem 1rem;
        border-radius: 15px;
        background: linear-gradient(112deg, var(--primary) 0%, #A97FDB 100%);
        padding: 0.5rem;
    }

    #controls .matrix-transformation::after {
        content: 'Matrix';
        color: var(--white);
        display: block;
        position: absolute;
        top: 50%;
        left: -2.5rem;
        transform: rotate(-90deg) translateX(20%);
        text-align: center;
        font-weight: 400;
    }

    #controls .matrix-transformation input {
        width: 6rem;
        border-radius: 10px;
        font-size: 1.2rem;
        background: radial-gradient(50% 50% at 50% 50%, #D4BDE9 0%, #DACAED 100%);
        box-shadow: 0px 0px 16.5px 0px rgba(177, 140, 222, 0.25);
        text-align: center;
        padding: 0.6rem 0.5rem;
        padding-left: 22px;
    }

    input[type='range'] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    input[type='range']:focus {
        outline: none;
    }

    input[type='range']::-webkit-slider-thumb {
        -webkit-appearance: none;
    }

    input[type='range']::-moz-range-thumb {
        border: none;
    }

    .range-slider {
        width: 100%;
        padding: 0 1rem 1rem 1rem;
    }

    .range-slider label {
        color: var(--white);
        width: 100%;
        text-align: center;
        font-weight: 400;
    }

    .range-slider input,
    .range-style {
        margin-top: 0.8rem;
        height: 15px;
        padding: 0px;
        background: var(--secondary);
        border: none;
        border-radius: 10px;
        width: 100%;
    }

    .range-slider input::-webkit-slider-runnable-track {
        display: flex;
        align-items: center;
        height: 20px;
        border-radius: 10px;
    }

    .range-slider input::-webkit-slider-thumb {
        position: relative;
        top: -30%;
        width: 30px;
        height: 30px;
        background-color: var(--light-primary);
        border-radius: 50%;
    }

    .range-slider input::-webkit-slider-thumb:hover {
        cursor: pointer;
        background-color: var(--primary);
    }

    .checklist {
        display: flex;
        flex-direction: row;
        align-items: center;
        width: 100%;
        padding: 0 1rem 1rem 1rem;
        gap: 0.5rem;
    }

    .checklist label {
        color: var(--white);
        font-weight: 400;
    }

    .checklist input {
        width: 1.2rem;
        height: 1.2rem;
        background-color: var(--accent);
        border: 2px solid var(--secondary);
        border-radius: 50%;
    }

    .checklist input:hover {
        cursor: pointer;
    }

    .checklist input:checked {
        background-color: var(--secondary);
    }

    #credits {
        border-radius: 20px;
        background: linear-gradient(112deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 1rem;
    }

    #credits h2 {
        color: var(--light-primary);
        font-weight: 400;
        text-shadow: 0 0 10px var(--secondary);
        margin-bottom: 1rem;
    }

    #credits .social {
        width: 4rem;
        height: 4rem;
        padding: 0.5rem;
        border-radius: 15px;
        background: radial-gradient(50% 50% at 50% 50%, #D4BDE9 0%, #DACAED 100%);
        box-shadow: 0px 0px 16.5px 0px rgba(177, 140, 222, 0.25);
    }

    #credits .social:hover {
        cursor: pointer;
        opacity: 0.6;
    }

    #canvas {
        height: 50%;
        width: 50%;
        overflow: hidden;
    }
</style>

<header class="d-flex align-items-center">
    <h1>may-tricks</h1>
    <?php include('./assets/svg/logo.svg'); ?>
</header>
<main class="d-flex flex-row w-100 h-100">
    <section id="information" class="d-flex flex-column align-items-center justify-content-between">
        <section id="controls" class="d-flex flex-column align-items-center w-100">
            <h2>controls</h2>
            <div class="matrix-transformation d-grid">
                <input type="number" id="a" value="0">
                <input type="number" id="b" value="1">
                <input type="number" id="c" value="1">
                <input type="number" id="d" value="0">
            </div>
            <div class="range-slider">
                <label for="columns">Scale</label>
                <input id="scale" type="range"/>
            </div>
            <div class="checklist">
                <input type="checkbox" id="fill">
                <label for="fill">Fill square</label>
            </div>
        </section>
        <section id="credits" class="d-flex flex-column align-items-center w-100">
            <h2>credits</h2>
            <div class="d-flex flex-row w-100 justify-content-between">
                <a class="social d-flex justify-content-center align-items-center" href="https://github.com/alexlostorto">
                    <?php include('./assets/svg/github.svg'); ?>
                </a>
                <a class="social d-flex justify-content-center align-items-center" href="https://www.linkedin.com/in/alex-lo-storto">
                    <?php include('./assets/svg/linkedin.svg'); ?>
                </a>
                <a class="social d-flex justify-content-center align-items-center" href="https://www.instagram.com/alexlostorto/">
                    <?php include('./assets/svg/instagram.svg'); ?>
                </a>
            </div>
        </section>
    </section>
    <section id="canvas" class="d-flex flex-column align-items-center w-100 h-100">
        <h2>canvas</h2>
        <div class="canvas-container d-flex align-items-center justify-content-center w-100 h-100"></div>
    </section>
</main>

<script type="module">

import * as THREE from 'https://threejs.org/build/three.module.js';

const canvasWidth = document.querySelector('#canvas .canvas-container').clientWidth;
const canvasHeight = document.querySelector('#canvas .canvas-container').clientHeight;

// Setup
const scene = new THREE.Scene();
let object = createSquare();
let square = object[0];
let edges = object[1];
const camera = new THREE.PerspectiveCamera(40, canvasWidth / canvasHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer();
renderer.setClearColor(0x1C1A29); // Set background color to accent colour
renderer.setSize(canvasWidth, canvasHeight);
document.querySelector('#canvas .canvas-container').appendChild(renderer.domElement);

// Set camera position
camera.position.z = 5;

// Animation
const animate = function () {
    requestAnimationFrame(animate);
    renderer.render(scene, camera);
};

createAxes();
createSquare();
animate();

document.querySelector('#a').addEventListener('input', applyMatrix);
document.querySelector('#b').addEventListener('input', applyMatrix);
document.querySelector('#c').addEventListener('input', applyMatrix);
document.querySelector('#d').addEventListener('input', applyMatrix);

function createSquare(fill=0x1C1A29) {
    // Create a unit square geometry
    const squareGeometry = new THREE.PlaneGeometry(1, 1);
    const material = new THREE.MeshBasicMaterial({ color: fill, side: THREE.DoubleSide });

    // Create custom index array excluding diagonals
    const indices = [
        0, 2,
        2, 3,
    ];

    const edgeGeometry = new THREE.BufferGeometry();
    edgeGeometry.setIndex(indices);
    edgeGeometry.setAttribute('position', squareGeometry.getAttribute('position'));

    // Create material for the edges
    const edgeMaterial = new THREE.LineBasicMaterial({ color: 0xD4BDE9, linewidth: 5 });

    // Create edges and original square
    const edges = new THREE.LineSegments(edgeGeometry, edgeMaterial);
    const square = new THREE.Mesh(squareGeometry, material);

    // Add the square and edges to the scene
    scene.add(square, edges);

    return [square, edges];
}

function createAxes() {
    // Create X and Y axis lines with a dashed pattern
    const dashedLineMaterial = new THREE.LineDashedMaterial({
        color: 0xDFDDF3, // Line color
        linewidth: 5,
        scale: 1,
        dashSize: 0.05, // Length of the dash
        gapSize: 0.05,  // Length of the gap between dashes
    });

    // X-axis
    const xAxisGeometry = new THREE.BufferGeometry().setFromPoints([
        new THREE.Vector3(-100, 0, 0),
        new THREE.Vector3(100, 0, 0),
    ]);
    const xAxisLine = new THREE.Line(xAxisGeometry, dashedLineMaterial);
    xAxisLine.computeLineDistances(); // This is important for dashed lines
    scene.add(xAxisLine);

    // Y-axis
    const yAxisGeometry = new THREE.BufferGeometry().setFromPoints([
        new THREE.Vector3(0, -100, 0),
        new THREE.Vector3(0, 100, 0),
    ]);
    const yAxisLine = new THREE.Line(yAxisGeometry, dashedLineMaterial);
    yAxisLine.computeLineDistances(); // This is important for dashed lines
    scene.add(yAxisLine);
}

function applyMatrix() {
    console.log(square);
    console.log(edges);
    scene.remove(square, edges);
    object = createSquare();
    square = object[0];
    edges = object[1];

    renderer.clear();
    
    const a = parseInt(document.getElementById('a').value);
    const b = parseInt(document.getElementById('b').value);
    const c = parseInt(document.getElementById('c').value);
    const d = parseInt(document.getElementById('d').value);

    const matrix = new THREE.Matrix4();
    matrix.set(
        a, b, 0, 0,
        c, d, 0, 0,
        0, 0, 1, 0,
        0, 0, 0, 1
    );
    square.geometry.applyMatrix4(matrix);
}

function changeScale(value) {
    camera.fov = value; // Set the desired FOV value
    camera.updateProjectionMatrix();
}

function fillSquare(fill) {
    if (fill) {
        createSquare(0x5e279f);
    } else {
        createSquare();
    }
}

function snap(input) {
	if (input.value < 55 && input.value > 45) {
		input.value = 50;
	} else if (input.value < 5) {
		input.value = 0;
    } else if (input.value > 95) {
        input.value = 100;
    }
}

document.querySelector('#scale').oninput = function() {
	snap(document.querySelector('#scale'));
	changeScale(document.querySelector('#scale').value - 10);
}

document.querySelector('#fill').onchange = function() {
    fillSquare(this.checked);
}
</script>

<?php include('./components/footer.php'); ?>