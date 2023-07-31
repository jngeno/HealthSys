
// Function to fetch symptoms from symptoms.json
async function fetchSymptoms() {
    try {
        const response = await fetch("symptoms.json");
        const symptomsData = await response.json();

        // Get the input element and the datalist
        const symptomsInput = document.getElementById("symptoms");
        const symptomsDatalist = document.getElementById("symptoms-list");

        // Clear any existing options in the datalist
        symptomsDatalist.innerHTML = "";

        // Add new options to the datalist based on the symptoms data
        symptomsData.forEach((symptom) => {
            const option = document.createElement("option");
            option.value = symptom.Name; // Use symptom Name for display in the input field
            option.setAttribute("data-id", symptom.ID); // Store the symptom ID as data attribute
            symptomsDatalist.appendChild(option);
        });
    } catch (error) {
        console.error("Error fetching symptoms:", error);
    }
}

// Function to fetch diagnosis results based on symptoms, gender, and year of birth
async function fetchDiagnosis(symptomIds, gender, yearOfBirth) {
    try {
        const apiUrl = `https://healthservice.priaid.ch/diagnosis`;
        const token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJlbWFpbCI6ImpvaG5uZ2Vuby5qbkBnbWFpbC5jb20iLCJyb2xlIjoiVXNlciIsImh0dHA6Ly9zY2hlbWFzLnhtbHNvYXAub3JnL3dzLzIwMDUvMDUvaWRlbnRpdHkvY2xhaW1zL3NpZCI6IjEwMDYwIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy92ZXJzaW9uIjoiMTA5IiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9saW1pdCI6IjEwMCIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbWVtYmVyc2hpcCI6IkJhc2ljIiwiaHR0cDovL2V4YW1wbGUub3JnL2NsYWltcy9sYW5ndWFnZSI6ImVuLWdiIiwiaHR0cDovL3NjaGVtYXMubWljcm9zb2Z0LmNvbS93cy8yMDA4LzA2L2lkZW50aXR5L2NsYWltcy9leHBpcmF0aW9uIjoiMjA5OS0xMi0zMSIsImh0dHA6Ly9leGFtcGxlLm9yZy9jbGFpbXMvbWVtYmVyc2hpcHN0YXJ0IjoiMjAyMy0wNy0yNCIsImlzcyI6Imh0dHBzOi8vYXV0aHNlcnZpY2UucHJpYWlkLmNoIiwiYXVkIjoiaHR0cHM6Ly9oZWFsdGhzZXJ2aWNlLnByaWFpZC5jaCIsImV4cCI6MTY5MDgwMTc4MiwibmJmIjoxNjkwNzk0NTgyfQ.t_7Izqp9xksAnDwzO9zRjEFTj3Td4fFd9lHY_2KSpH0"; // Replace with your actual authentication token

        // Construct the query parameters for the diagnosis API
        const params = new URLSearchParams({
            token: token,
            language: "en-gb",
            symptoms: JSON.stringify(symptomIds),
            gender: gender,
            year_of_birth: yearOfBirth
        });

        // Make the GET request to the diagnosis API
        const response = await fetch(`${apiUrl}?${params}`);

        if (!response.ok) {
            throw new Error("Failed to fetch diagnosis results.");
        }

        // Parse the response as JSON
        const diagnosisResults = await response.json();

        // Process the diagnosisResults here
        // ...

        return diagnosisResults; // Return the diagnosis results
    } catch (error) {
        console.error("Error fetching diagnosis:", error);
        throw error;
    }
}

document.getElementById("diagnosis-form").addEventListener("submit", async (event) => {
    event.preventDefault();

    // Fetch symptoms when the form is submitted
    await fetchSymptoms();

    // Extract the selected symptom ID from the datalist
    const selectedSymptom = document.querySelector("#symptoms-list option[value='" + symptomsInput.value + "']");
    const symptomId = selectedSymptom ? selectedSymptom.getAttribute("data-id") : null;

    // Get other form data (gender and year of birth)
    const gender = document.getElementById("gender").value;
    const yearOfBirth = document.getElementById("year-of-birth").value;

    if (symptomId && gender && yearOfBirth) {
        // Call the fetchDiagnosis function with the selected symptom ID, gender, and year of birth
        try {
            const diagnosisResults = await fetchDiagnosis([symptomId], gender, yearOfBirth);

            // Process and display the diagnosis results here
            console.log(diagnosisResults);
        } catch (error) {
            console.error("Error fetching diagnosis:", error);
        }
    }
});

// Fetch symptoms when the page loads
fetchSymptoms();

