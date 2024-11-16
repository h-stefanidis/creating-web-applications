/* Filename: apply.js
Target php: apply.php, jobs.php
Purpose: Aims to validate apply.php data inputs and correctly transfer data using local and session storage
Author: Harrison Stefanidis
Date written: 26/04/2024
*/
// Validation for form data input
function validate() {
    var result = true;

    var dob = document.getElementById("dob").value;
    var state = document.getElementById("state").value;
    var postcode = document.getElementById("postcode").value;

    // Remove any existing error messages
    var dobErrorMessage = document.getElementById("dobError");
    if (dobErrorMessage) {
        dobErrorMessage.parentNode.removeChild(dobErrorMessage);
    }

    var stateErrorMessage = document.getElementById("stateError");
    if (stateErrorMessage) {
        stateErrorMessage.parentNode.removeChild(stateErrorMessage);
    }

    var skillsErrorMessage = document.getElementById("skillsError");
    if (skillsErrorMessage) {
        skillsErrorMessage.parentNode.removeChild(skillsErrorMessage);
    }

    // Validate the date of birth format
    var dobRegex = /^\d{2}\/\d{2}\/\d{4}$/;
    if (!dob) {
        var dobField = document.getElementById("dob");
        dobField.setCustomValidity("Please enter your date of birth.");
        result = false;
    } else if (!dobRegex.test(dob)) {
        result = false;
        createErrorMessage("dobError", "Your date of birth must be in the format dd/mm/yyyy.", "dob");
    } else {
        var dobDate = new Date(dob);
        var currentDate = new Date();
        var age = currentDate.getFullYear() - dobDate.getFullYear();
        var monthDiff = currentDate.getMonth() - dobDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && currentDate.getDate() < dobDate.getDate())) {
            age--;
        }
        if (age < 18 || age > 80) {
            result = false;
            createErrorMessage("dobError", "Your age must be between 18 and 80.", "dob");
        }
    }

    // Validate postcode based on state
    var validPostcodes = {
        "VIC": ["3", "8"],
        "NSW": ["1", "2"],
        "QLD": ["4", "9"],
        "NT": ["0"],
        "WA": ["6"],
        "SA": ["5"],
        "TAS": ["7"],
        "ACT": ["0"]
    };

    if (!validPostcodes[state].includes(postcode.charAt(0))) {
        result = false;
        createErrorMessage("stateError", "The first digit of the selected state must match the first digit of the postcode.", "postcode");
    }

    // Check if "Other Skills" checkbox is checked and validate the textarea
    var otherSkillsCheckbox = document.querySelector('input[name="Skills[]"][value="Other Skills"]');
    var otherSkillsTextarea = document.querySelector('textarea[name="OtherSkills"]');
    if (otherSkillsCheckbox.checked && otherSkillsTextarea.value.trim() === "") {
        result = false;
        createErrorMessage("skillsError", "If you selected 'Other Skills', please provide details in the text box above.", "skillsets");
    }

    if (result) {
        storeFormData(); // Store form data in session storage if validation passes
    }

    return result;
}

// Error message template function
function createErrorMessage(id, message, fieldId) {
    var errorMessage = document.createElement("div");
    errorMessage.id = id;
    errorMessage.className = "error";
    errorMessage.textContent = message;

    // Apply default browser validation styles to the error message
    errorMessage.style.color = "red"; 
    errorMessage.style.fontFamily = "Arial, sans-serif"; 
    errorMessage.style.fontSize = "12px"; 
    errorMessage.style.marginTop = "5px"; 

    // Insert the error message after the specified field
    var field = document.getElementById(fieldId);
    field.parentNode.insertBefore(errorMessage, field.nextSibling);
}

// Function to store application code in local storage
function storeApplication(code) {
    localStorage.setItem("applicationCode", code);
}

// Function to handle clicking the hyperlink for SA403
function handleSA403ApplyLinkClick() {
    storeApplication("SA403");
    alert("Application code SA403 has been stored in local storage.");
}

// Function to handle clicking the hyperlink for IT285
function handleIT285ApplyLinkClick() {
    storeApplication("IT285");
    alert("Application code IT285 has been stored in local storage.");
}

// Function to initialise the script on apply.php
function initApplyPage() {
    var regForm = document.getElementById("regform"); 
    regForm.onsubmit = validate;

    // Retrieve the application code from local storage
    var applicationCode = localStorage.getItem("applicationCode");

    // Set the value of the text input with id "refnum"
    var refNumInput = document.getElementById("refnum");
    refNumInput.value = applicationCode;
    refNumInput.setAttribute("readonly", "readonly");

    // Retrieve and set other form field values from session storage
    var fnameInput = document.getElementById("fname");
    fnameInput.value = sessionStorage.getItem("fname") || "";

    var lnameInput = document.getElementById("lname");
    lnameInput.value = sessionStorage.getItem("lname") || "";

    var dobInput = document.getElementById("dob");
    dobInput.value = sessionStorage.getItem("dob") || "";

    var streetInput = document.getElementById("street");
    streetInput.value = sessionStorage.getItem("street") || "";

    var subtownInput = document.getElementById("subtown");
    subtownInput.value = sessionStorage.getItem("subtown") || "";

    var postcodeInput = document.getElementById("postcode");
    postcodeInput.value = sessionStorage.getItem("postcode") || "";

    var phoneInput = document.getElementById("phone");
    phoneInput.value = sessionStorage.getItem("phone") || "";

    var emailInput = document.getElementById("email");
    emailInput.value = sessionStorage.getItem("email") || "";

    var genderInputs = document.querySelectorAll('input[name="gender"]');
    genderInputs.forEach(function(input) {
        if (input.value === sessionStorage.getItem("gender")) {
            input.checked = true;
        }
    });

    var stateInput = document.getElementById("state");
    stateInput.value = sessionStorage.getItem("state") || "";

    var skillsTextarea = document.getElementById("otherskills");
    skillsTextarea.value = sessionStorage.getItem("otherskills") || "";

    var otherSkillsCheckbox = document.querySelector('input[name="Skills[]"][value="Other Skills"]');
    otherSkillsCheckbox.checked = sessionStorage.getItem("otherSkillsChecked") === "true";
}

// Function to store form data in session storage
function storeFormData(jobReference) {
    var fnameInput = document.getElementById("fname");
    sessionStorage.setItem("fname", fnameInput.value);

    var lnameInput = document.getElementById("lname");
    sessionStorage.setItem("lname", lnameInput.value);

    var dobInput = document.getElementById("dob");
    sessionStorage.setItem("dob", dobInput.value);

    var streetInput = document.getElementById("street");
    sessionStorage.setItem("street", streetInput.value);

    var subtownInput = document.getElementById("subtown");
    sessionStorage.setItem("subtown", subtownInput.value);

    var postcodeInput = document.getElementById("postcode");
    sessionStorage.setItem("postcode", postcodeInput.value);

    var phoneInput = document.getElementById("phone");
    sessionStorage.setItem("phone", phoneInput.value);

    var emailInput = document.getElementById("email");
    sessionStorage.setItem("email", emailInput.value);

    var genderInputs = document.querySelectorAll('input[name="Gender"]');
    genderInputs.forEach(function(input) {
        if (input.checked) {
            sessionStorage.setItem("gender", input.value);
        }
    });

    var stateInput = document.getElementById("state");
    sessionStorage.setItem("state", stateInput.value);

    var selectedSkills = [];
    var skillsCheckboxes = document.querySelectorAll('input[name="Skills[]"]:checked');
    skillsCheckboxes.forEach(function(checkbox) {
        selectedSkills.push(checkbox.value);
    });
    sessionStorage.setItem("skills", selectedSkills.join(','));

    var skillsTextarea = document.getElementById("otherskills");
    sessionStorage.setItem("otherskills", skillsTextarea.value);

    var otherSkillsCheckbox = document.querySelector('input[name="Skills[]"][value="Other Skills"]');
    sessionStorage.setItem("otherSkillsChecked", otherSkillsCheckbox.checked);

    // Store the job reference number
    sessionStorage.setItem("jobReference", jobReference);
}

// Function to initialise the script on jobs.php
function initJobsPage() {
    // Add event listener to the hyperlink with id "sysadmapply"
    var sysAdmApplyLink = document.getElementById("sysadmapply");
    sysAdmApplyLink.addEventListener("click", function() {
        // Store the application code "SA403" in local storage
        storeApplication("SA403");
        // Redirect to the apply.php page
        window.location.href = "apply.php";
    });

    // Add event listener to the hyperlink with id "itcoapply"
    var itCoApplyLink = document.getElementById("itcoapply");
    itCoApplyLink.addEventListener("click", function() {
        // Store the application code "IT285" in local storage
        storeApplication("IT285");
        // Redirect to the apply.php page
        window.location.href = "apply.php";
    });
}

// Function to determine the current page and initialise accordingly
function initPage() {
    var currentPageUrl = window.location.href;
    if (currentPageUrl.includes("apply.php")) {
        initApplyPage();
    } else if (currentPageUrl.includes("jobs.php")) {
        initJobsPage();
    }
}

// Call the initPage function when the window loads
window.onload = initPage;
