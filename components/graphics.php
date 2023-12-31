<script type="module">

class Colours {
    constructor() {
        this.secondary = 0xD4BDE9;
        this.tertiary = 0x5e279f;
        this.accent = 0x1C1A29;
        this.white = 0xDFDDF3;
    }
}

class Controls {
    constructor() {
        this.a = document.getElementById('a');
        this.b = document.getElementById('b');
        this.c = document.getElementById('c');
        this.d = document.getElementById('d');
        this.fov = 50;
        this.transform = document.getElementById('transform');
        this.scale = document.getElementById('scale');
        this.fill = document.getElementById('fill');
        this.hide = document.getElementById('hide-axes');
        this.reset = document.getElementById('reset');
        this.output = document.getElementById('output');
        this.animate = true;
        this.animateDuration = 2000;
        this.loadEventListeners();
    }

    sleep(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    loadEventListeners() {
        this.transform.addEventListener('click', this.applyMatrix.bind(this));
        this.scale.addEventListener('input', this.changeScale);
        this.fill.addEventListener('input', this.fillSquare);
        this.hide.addEventListener('input', this.hideAxes);
        this.reset.addEventListener('click', () => {
            this.reset.classList.add('animate');  // Add the 'animate' class to trigger the animation
            this.resetMatrix();
            setTimeout(function() {
                this.reset.classList.remove('animate');
            }, 500);  // Half a second, length of animation
        });
        this.a.addEventListener('keydown', function(event) {
            if (event.key === "Enter") {controls.applyMatrix()}
        });
        this.b.addEventListener('keydown', function(event) {
            if (event.key === "Enter") {controls.applyMatrix()}
        });
        this.c.addEventListener('keydown', function(event) {
            if (event.key === "Enter") {controls.applyMatrix()}
        });
        this.d.addEventListener('keydown', function(event) {
            if (event.key === "Enter") {controls.applyMatrix()}
        });
    }

    getMatrix() {
        const a = this.a.value;
        const b = this.b.value;
        const c = this.c.value;
        const d = this.d.value;
        const matrix = new THREE.Matrix4();
        matrix.set(
            a, b, 0, 0,
            c, d, 0, 0,
            0, 0, 1, 0,
            0, 0, 0, 1
        );

        return matrix;
    }

    applyMatrix() {
        const a = this.a.value;
        const b = this.b.value;
        const c = this.c.value;
        const d = this.d.value;

        if (!a || !b || !c || !d) {
            popup.displayNAN();
            return;
        }

        if ((a * d - b * c) == 0) {
            popup.displayDeterminantZero();
            return;
        }

        transformation.describe(a, b, c, d);

        this.matrix = this.getMatrix();

        graphics.unitSquare.square.geometry.applyMatrix4(this.matrix);
    }

    changeScale() {
        controls.snap(this);
        controls.fov = this.value < 50 ? (this.value-50)/2+50 : this.value;
        graphics.camera.fov = controls.fov;
        graphics.camera.updateProjectionMatrix();
    }

    fillSquare() {
        if (this.checked) {
            graphics.unitSquare.changeFillColour(colours.tertiary);
        } else {
            graphics.unitSquare.changeFillColour(colours.accent);
        }
    }

    hideAxes() {
        if (this.checked) {
            const dashedLineMaterial = new THREE.LineDashedMaterial({
                opacity: 0,
                visible: false,
            })
            graphics.axes.lines[0].material = dashedLineMaterial;
            graphics.axes.lines[1].material = dashedLineMaterial;
        } else {
            const dashedLineMaterial = new THREE.LineDashedMaterial({
                color: graphics.axes.lineColour,
                linewidth: graphics.axes.lineWidth,
                scale: graphics.axes.scale,
                dashSize: graphics.axes.dashSize,
                gapSize: graphics.axes.gapSize
            });
            graphics.axes.lines[0].material = dashedLineMaterial;
            graphics.axes.lines[1].material = dashedLineMaterial;
        }
    }

    resetMatrix() {
        graphics.unitSquare.square.geometry = new THREE.PlaneGeometry(1, 1);
        graphics.unitSquare.square.geometry.translate(0.5, 0.5, 0);
        graphics.unitSquare.edges.geometry.setAttribute('position', graphics.unitSquare.square.geometry.getAttribute('position'));
    }

    snap(input) {
        if (input.value < 55 && input.value > 45) {
            input.value = 50;
        } else if (input.value < 5) {
            input.value = 0;
        } else if (input.value > 95) {
            input.value = 100;
        }
    }
}

class Transformation {
    constructor(a, b, c, d) {
        this.a = a;
        this.b = b;
        this.c = c;
        this.d = d;
    }

    describe(a, b, c, d) {
        this.a = a;
        this.b = b;
        this.c = c;
        this.d = d;

        if (this.isIdentityMatrix()) {
            controls.output.textContent = 'Identity matrix';
        } else if (this.isEnlargementMatrix()) {
            controls.output.textContent = `Enlargement Scale Factor ${this.a} about (0, 0)`;
        } else if (this.isShearXMatrix()) {
            controls.output.textContent = `Shear Scale Factor ${this.b} in x-direction`;
        } else if (this.isShearYMatrix()) {
            controls.output.textContent = `Shear Scale Factor ${this.c} in y-direction`;
        } else if (this.isRotationMatrix()) {
            controls.output.textContent = `Rotation ${Math.acos(a) * (180 / Math.PI)} degrees`;
        } else if (this.isReflectionXMatrix()) {
            controls.output.textContent = 'Reflection along x-axis';
        } else if (this.isReflectionYMatrix()) {
            controls.output.textContent = 'Reflection along y-axis';
        } else if (this.isReflectionYEqualsXMatrix()) {
            controls.output.textContent = 'Reflection along y=x';
        } else if (this.isReflectionYEqualsNegativeXMatrix()) {
            controls.output.textContent = 'Reflection along y=-x';
        } else if (this.isStretchMatrix()) {
            controls.output.textContent = `Stretch Scale Factor ${this.a} in x-axis and Stretch Scale Factor ${this.d} in y-axis`;
        } else {
            controls.output.textContent = 'Unknown transformation';
        }
    }

    isIdentityMatrix() {
        return (this.a == 1 && this.b == 0 && this.c == 0 && this.d == 1);
    }

    isEnlargementMatrix() {
        return (this.a != 1 && this.a == this.d && this.b == 0 && this.c == 0);
    }

    isStretchMatrix() {
        return (this.b == 0 && this.c == 0);
    }

    isShearXMatrix() {
        return (this.a == 1 && this.b != 0 && this.c == 0 && this.d == 1);
    }

    isShearYMatrix() {
        return (this.a == 1 && this.b == 0 && this.c != 0 && this.d == 1);
    }

    isRotationMatrix() {
        return (this.a == this.d && this.b == -this.c);
    }

    isReflectionXMatrix() {
        return (this.a == 1 && this.b == 0 && this.c == 0 && this.d == -1);
    }

    isReflectionYMatrix() {
        return (this.a == -1 && this.b == 0 && this.c == 0 && this.d == 1);
    }

    isReflectionYEqualsXMatrix() {
        return (this.a == 0 && this.b == 1 && this.c == 1 && this.d == 0);
    }

    isReflectionYEqualsNegativeXMatrix() {
        return (this.a == 0 && this.b == -1 && this.c == -1 && this.d == 0);
    }
}

class Graphics {
    constructor() {
        this.canvasContainer = document.querySelector('#canvas .canvas-container');
        this.canvasWidth = document.querySelector('#canvas .canvas-container').clientWidth;
        this.canvasHeight = document.querySelector('#canvas .canvas-container').clientHeight;
        this.camera = new THREE.PerspectiveCamera(40, this.canvasWidth / this.canvasHeight, 0.1, 1000);
        this.renderer = new THREE.WebGLRenderer();
        this.scene = new THREE.Scene();
        this.unitSquare = new UnitSquare(this.scene);
        this.axes = new Axes(this.scene);
    }

    setup() {
        this.camera.fov = controls.fov;
        this.camera.updateProjectionMatrix();
        this.camera.position.z = 5;
        this.renderer.setClearColor(colours.accent);  // Set background color to accent colour
        this.renderer.setSize(this.canvasWidth, this.canvasHeight);
        this.canvasContainer.appendChild(this.renderer.domElement);
        this.animate();
    }

    animate() {
        requestAnimationFrame(this.animate.bind(this));
        this.renderer.render(this.scene, this.camera);
    };
}

class UnitSquare {
    constructor(scene) {
        this.fillColour = colours.tertiary;
        this.edgeColour = colours.secondary;
        this.lineWidth = 5;
        this.square = this.createSquare(scene);
        this.edges = this.createEdges(scene);

        return this;
    }

    changeFillColour(colour) {
        this.fillColour = colour;
        this.square.material.color.set(this.fillColour);
    }

    createSquare(scene) {
        const squareGeometry = new THREE.PlaneGeometry(1, 1);
        const material = new THREE.MeshBasicMaterial({ color: this.fillColour, side: THREE.DoubleSide });

        const square = new THREE.Mesh(squareGeometry, material);
        squareGeometry.translate(0.5, 0.5, 0);
        scene.add(square);

        return square;
    }

    createEdges(scene) {
        // Show only bottom and left sides
        const indices = [
            0, 1,
            0, 2,
            2, 3,
            1, 3,
        ];

        const edgeGeometry = new THREE.BufferGeometry();
        edgeGeometry.setIndex(indices);
        edgeGeometry.setAttribute('position', this.square.geometry.getAttribute('position'));

        // Create material for the edges
        const edgeMaterial = new THREE.LineBasicMaterial({ color: this.edgeColour, linewidth: this.lineWidth });
        const edges = new THREE.LineSegments(edgeGeometry, edgeMaterial);
        scene.add(edges);

        return edges
    }
}

class Axes {
    constructor(scene) {
        this.lineWidth = 5;
        this.lineColour = colours.white;
        this.dashSize = 0.05;
        this.gapSize = 0.05;
        this.scale = 1;
        this.lines = this.create(scene);

        return this;
    }

    create(scene) {
        // Create X and Y axis lines with a dashed pattern
        const dashedLineMaterial = new THREE.LineDashedMaterial({
            color: this.lineColour,
            linewidth: this.lineWidth,
            scale: this.scale,
            dashSize: this.dashSize,
            gapSize: this.gapSize
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

        return [xAxisLine, yAxisLine];
    }
}

import * as THREE from '/may-tricks/assets/lib/three.module.js';

const popup = new Popup();
const transformation = new Transformation();
const colours = new Colours();
let graphics = new Graphics();
const controls = new Controls();

graphics.setup();

</script>