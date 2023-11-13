<?php

$seo_keywords = 'Matrix transformations, matrices, matrix, transformations, transformation, translation, rotation, enlargements, 3d, 3d matrix, 3d transformation, 3d transformations, stretch, shear';
$seo_description = "We're stuck in the matrix!";
$seo_author = 'Alex lo Storto';
$site_title = 'Matrix Transformations';

$title = 'Matrix Transformations';

include('./components/header.php');

?>

<style>
    * {
        margin: 0px;
        padding: 0px;
    }

    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    canvas {
        border: 1px solid #ccc;
        height: 20rem;
        width: 20rem;
    }

    canvas:hover {
        cursor: pointer;
    }
</style>

<canvas id="canvas"></canvas>

<script>

const canvas = document.getElementById("canvas");
const context = canvas.getContext("2d");

// Variables for pan navigation
let isDragging = false;
let dragStart = { x: 0, y: 0 };
let offset = { x: 0, y: 0 };

// Define a unit square
const square = [
    { x: 0, y: 0 },
    { x: 1, y: 0 },
    { x: 1, y: 1 },
    { x: 0, y: 1 }
];

// Function to draw a polygon on the canvas
function drawPolygon(points, color) {
    context.beginPath();
    context.moveTo(points[0].x * (canvas.width/3), points[0].y * (canvas.height/3));

    for (let i = 1; i < points.length; i++) {
        context.lineTo(points[i].x * (canvas.width/3), points[i].y * (canvas.height/3));
    }

    context.closePath();
    context.fillStyle = color;
    context.fill();
}

// Function to apply a 2x2 matrix transformation to a set of points
function applyMatrix(points, matrix) {
    return points.map(point => ({
        x: matrix[0] * point.x + matrix[1] * point.y,
        y: matrix[2] * point.x + matrix[3] * point.y
    }));
}

// Draw x and y axes
const xAxis = [{ x: 0, y: 0 }, { x: 1, y: 0 }];
const yAxis = [{ x: 0, y: 0 }, { x: 0, y: 1 }];
drawPolygon(xAxis, "black");
drawPolygon(yAxis, "black");

// Initial square color: blue
drawPolygon(square, "blue");

// Apply a matrix transformation: scaling by 2 in the x-direction
const scalingMatrix = [0, -1, -1, 0];
const transformedSquare = applyMatrix(square, scalingMatrix);

// Draw the transformed square color: red
drawPolygon(transformedSquare, "red");

// Mouse event handlers for panning
canvas.addEventListener("mousedown", handleMouseDown);
canvas.addEventListener("mousemove", handleMouseMove);
canvas.addEventListener("mouseup", handleMouseUp);
canvas.addEventListener("mouseleave", handleMouseLeave);

function handleMouseDown(event) {
    isDragging = true;
    dragStart = { x: event.clientX, y: event.clientY };
}

function handleMouseMove(event) {
    if (isDragging) {
        const deltaX = event.clientX - dragStart.x;
        const deltaY = event.clientY - dragStart.y;

        offset.x += deltaX / canvas.width;
        offset.y += deltaY / canvas.height;

        context.clearRect(0, 0, canvas.width, canvas.height);

        // Draw original square color: blue
        console.log("Drawing rect");
        drawPolygon(square, "blue");

        // Apply a matrix transformation: reflection across the x-axis with panning
        const reflectionMatrixXPanned = [1, 0, 0, -1];
        const reflectedSquareXPanned = applyMatrix(square, reflectionMatrixXPanned);

        console.log(reflectedSquareXPanned);

        // Draw the reflected square color: red
        drawPolygon(reflectedSquareXPanned, "red");

        // Apply a matrix transformation: reflection across the y-axis with panning
        const reflectionMatrixYPanned = [-1, 0, 0, 1];
        const reflectedSquareYPanned = applyMatrix(square, reflectionMatrixYPanned);

        // Draw the reflected square color: green
        drawPolygon(reflectedSquareYPanned, "green");

        dragStart = { x: event.clientX, y: event.clientY };
    }
}

function handleMouseUp() {
    isDragging = false;
}

function handleMouseLeave() {
    isDragging = false;
}

</script>

<?php include('./components/footer.php'); ?>