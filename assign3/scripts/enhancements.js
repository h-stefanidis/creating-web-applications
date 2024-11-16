/* Filename: enhancements.js
Target php: apply.php
Purpose : Provides enhancements for Assignment 2
Author: Harrison Stefanidis
Date written: 28/04/2024
*/

// Enhancement 2 - Slideshow
var slideIndex = 0; // Declare slideIndex outside of any function

function plusSlides(n) {
    showSlides(slideIndex += n);
}

function currentSlide(n) {
    showSlides(slideIndex = n);
}

function showSlides() {
    var i;
    var slides = document.getElementsByClassName("slides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = "block";
}

function startSlideshow() {
    setInterval(showSlides, 2000); // Change image every 2 seconds
}

// Enhancement 1 - Timer for Application
function startTimer() {
    setTimeout(function() {
        alert("Time limit reached. Please try applying again.");
        window.location.href = "index.php";
    }, 5 * 60 * 1000); // 5 minutes in milliseconds
}

function initEnhancements() {
    var currentPageUrl = window.location.href;
    if (currentPageUrl.includes("jobs.php")) {
        startSlideshow(); // Call startSlideshow function only on jobs.php
    } else if (currentPageUrl.includes("apply.php")) {
        startTimer(); // Call startTimer function only on apply.php
    }

    // Hide all slides except the first one
    var slides = document.getElementsByClassName("slides");
    for (var i = 1; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    initEnhancements();
});
