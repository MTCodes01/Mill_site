/* Place your JavaScript in this file */
document.getElementById("millForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission

    // Get the data from the input fields
    var optionValue = document.getElementById("option").value;
    var weightValue = parseFloat(document.getElementById("weight").value);

    if (isNaN(weightValue) || weightValue <= 0) {
        document.getElementById("total").textContent = "Input Weight";
        document.getElementById("total").style.backgroundColor = "#FF5555";
        return;
    }

    var options = {
        "python": 5,
        "customtkinter": 3,
        "widgets": 2,
        "options": 4,
        "menu": 6,
        "combobox": 7,
        "dropdown": 8,
        "search": 9
    };

    var total = options[optionValue] * weightValue;
    document.getElementById("total").textContent = "Total: " + (total % 1 === 0 ? total.toFixed(0) : total.toFixed(2));
    document.getElementById("total").style.backgroundColor = "#4CAF50";

    // Make AJAX request to submit the data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "/submit", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    var data = {
        option: optionValue,
        weight: weightValue
    };

    xhr.send(JSON.stringify(data));
});
