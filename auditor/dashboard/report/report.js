function submitReport() {
    const reportText = document.getElementById("reportText").value;
    if (reportText.trim() === "") {
        alert("Please enter some text before submitting!");
        return;
    }

    const listItem = document.createElement("li");
    listItem.textContent = reportText;

    document.getElementById("reportList").appendChild(listItem);
    document.getElementById("reportText").value = ""; // Clear textarea after submitting
}
// Function to handle the 'Go Back' button action
function goBack() {
    window.history.back(); // Navigate back to the previous page
}

