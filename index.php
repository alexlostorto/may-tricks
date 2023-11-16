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

    #information {
        gap: 2rem;
    }

    #controls,
    #canvas,
    #transform {
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

    #transform {
        margin-top: 2rem;
        font-size: 1.6rem;
        padding: 1rem;
        background: linear-gradient(112deg, var(--primary) 0%, var(--secondary) 100%);
        color: var(--light-primary);
        font-weight: 400;
        text-shadow: 0 0 10px var(--secondary);
    }

    #transform:hover {
        background: var(--accent);
        font-weight: 200;
        color: var(--secondary);
        text-shadow: 0 0 50px var(--secondary);
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

    #reset {
        right: 2rem;
        bottom: 1rem;
        gap: 0.2rem;
    }

    #reset.animate svg {
        animation: spin 0.5s ease forwards;
    }

    #reset svg {
        width: 2.5rem;
        height: auto;
    }

    #reset label {
        color: var(--white);
        font-weight: 400;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(-360deg);
        }
    }

    #github {
        position: fixed;
        right: 0;
        top: 0;
        border-bottom-left-radius: 20px;
        background: linear-gradient(112deg, var(--primary) 0%, var(--secondary) 100%);
        padding: 0.5rem;
        background: radial-gradient(50% 50% at 50% 50%, #D4BDE9 0%, #DACAED 100%);
        box-shadow: 0px 0px 16.5px 0px rgba(177, 140, 222, 0.25);
    }

    #github:hover {
        cursor: pointer;
        box-shadow: 0px 0px 50px 20px rgba(177, 140, 222, 0.25);
    }

    #github:hover svg {
        animation: wave 0.5s ease forwards;
    }

    @keyframes wave {
        0% {
            transform: rotate(0deg);
        }

        30% {
            transform: rotate(30deg);
        }

        60% {
            transform: rotate(-30deg);
        }

        100% {
            transform: rotate(0deg);
        }
    }

    #canvas {
        height: 50%;
        width: 50%;
        overflow: hidden;
    }

    #canvas .canvas-container {
        overflow: hidden;
    }
</style>

<header class="d-flex align-items-center">
    <h1>may-tricks</h1>
    <?php include('./assets/svg/logo.svg'); ?>
    <a id="github" class="d-flex justify-content-center align-items-center" href="https://github.com/alexlostorto/may-tricks" target="_blank">
        <?php include('./assets/svg/github.svg'); ?>
    </a>
</header>
<main class="d-flex flex-row w-100 h-100">
    <section id="information" class="d-flex flex-column align-items-center justify-content-between">
        <div>
            <section id="controls" class="position-relative d-flex flex-column align-items-center w-100">
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
                    <input type="checkbox" id="fill" checked="true">
                    <label for="fill">Fill square</label>
                </div>
                <div class="checklist">
                    <input type="checkbox" id="hide-axes">
                    <label for="hide-axes">Hide axes</label>
                </div>
                <button id="reset" class="position-absolute d-flex flex-column">
                    <?php include('./assets/svg/reset.svg'); ?>
                    <label for="reset">Reset</label>
                </button>
            </section>
            <button id="transform" class="w-100">transform</button>
        </div>
    </section>
    <section id="canvas" class="d-flex flex-column align-items-center w-100 h-100">
        <h2>canvas</h2>
        <div class="canvas-container d-flex align-items-center justify-content-center w-100 h-100"></div>
    </section>
</main>

<?php include('./components/graphics.php'); ?>
<?php include('./components/footer.php'); ?>