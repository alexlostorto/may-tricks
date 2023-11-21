<?php

// PREVENT DIRECT ACCESS
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    // The file is being accessed directly
    http_response_code(403);
    header("Location: /403/");
    exit;
}
// PREVENT DIRECT ACCESS

?>

<style>
    .hidden {
        display: none !important;
    }

    #popup {
        top: 0;
        left: 0;
    }

    .blur-overlay {
        z-index: 9999;
        top: 0;
        left: 0;
        backdrop-filter: blur(5px);
    }

    .popup-container {
        z-index: 999999;
        background-color: var(--accent);
        border: 1px solid var(--secondary);
        box-shadow: 0 0 20px #B28DDE;
        border-radius: 10px;
        width: clamp(8rem, 50%, 20rem);
        padding: 0.5rem 1rem;
    }

    .popup-container #popup-header {
        padding-bottom: 0.5rem;
        font-weight: 200;
        color: var(--secondary);
        text-shadow: 0 0 50px var(--secondary);
    }

    .popup-container #popup-content {
        color: var(--white);
        font-weight: 300;
    }

    .popup-container .button-container {
        width: 100%;
        padding: 0.5rem;
    }

    .popup-container .save-button {
        margin: 0.5rem;
        width: auto;
        min-height: 2.7rem;
        padding: 0.6rem 0;
        border-radius: 10px;
        background-color: var(--secondary);
        color: var(--primary);
    }

    .popup-container .save-button:hover {
        color: var(--secondary);
        background-color: var(--accent);
        outline: 2px solid var(--secondary);
    }

    #close-popup-button {
        top: 0.5rem;
        right: 0.5rem;
        justify-content: flex-end;
        line-height: 0;
        padding: 0.5rem;
        border-radius: 7px;
    }

    #close-popup-button svg path {
        stroke: var(--accent);
        fill: var(--white);
    }

    #close-popup-button:hover {
        background-color: var(--secondary);
    }

    #close-popup-button:hover svg path {
        stroke: var(--secondary);
    }

    @media(max-width: 400px) {
        .popup-container {
            width: clamp(8rem, 80%, 18rem);
        }
    }
</style>

<div id="popup" class="position-absolute d-flex flex-column justify-content-center align-items-center w-100 h-100 hidden">
    <div class="blur-overlay position-absolute w-100 h-100"></div>
    <div class="popup-container position-absolute d-flex flex-column justify-content-center align-items-center">
        <div class="button-container d-flex justify-content-end align-items-center">
            <button id="close-popup-button" class="position-absolute">
                <?php  // Thin Exit button
                    $style = "position: absolute; bottom: 20%; left: 10%; width: 8rem; height: 8rem; fill: var(--tertiary);";
                    include("./assets/svg/x.svg");
                ?>
            </button>
        </div>
        <h2 id="popup-header" class="header"></h2>
        <p id="popup-content" class="content text-center"></p>
        <button id="save-popup-button" class="save-button w-100"></button>
    </div>
</div>

<script>

class Popup {
    constructor() {
        this.popup = document.querySelector("#popup");
        this.header = this.popup.querySelector(".header");
        this.content = this.popup.querySelector(".content");
        this.button = this.popup.querySelector(".save-button");
        this.loadEventListeners();
    }

    displayPopup(header, content, buttonText, buttonFunction) {
        this.header.innerHTML = header;
        this.content.innerHTML = content;
        this.button.innerHTML = buttonText;
        this.button.onclick = buttonFunction;
        this.showPopup();
    }

    displayDeterminantZero() {
        let header = "Warning";
        let content = "Determinant is zero.";
        let buttonText = "Try again";
        let buttonFunction = () => { this.popup.classList.add("hidden") };

        this.displayPopup(header, content, buttonText, buttonFunction);
    }

    displayNAN() {
        let header = "Warning";
        let content = "Input is not a number.";
        let buttonText = "Try again";
        let buttonFunction = () => { this.popup.classList.add("hidden") };

        this.displayPopup(header, content, buttonText, buttonFunction);
    }

    loadEventListeners() {
        this.popup.querySelector("#close-popup-button").addEventListener("click", this.hidePopup.bind(this));
        this.popup.querySelector("#save-popup-button").addEventListener("click", this.hidePopup.bind(this));
    }
    
    showPopup() {
        if (this.popup.classList.contains("hidden")) {
            this.popup.classList.remove("hidden");
        }
    }

    hidePopup() {
        if (!this.popup.classList.contains("hidden")) {
            this.popup.classList.add("hidden");
        }
    }
}

</script>