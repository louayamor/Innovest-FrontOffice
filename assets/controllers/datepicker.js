<!-- Include necessary JavaScript libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">

<!-- Your HTML form and date field -->
<form id="user_profile_form">
    <label for="user_profile_Age">Date of Birth:</label>
    <input type="text" id="user_profile_Age" name="user_profile[Age]">
</form>

<!-- JavaScript code to initialize the datepicker -->
<script>
    $(document).ready(function() {
        // Initialize the datepicker on the Age input field
        $("#user_profile_Age").datepicker({
            dateFormat: 'yy-mm-dd', // Date format (e.g., YYYY-MM-DD)
            changeMonth: true, // Allow changing the month
            changeYear: true, // Allow changing the year
            yearRange: '1900:2024', // Specify the range of selectable years
            showButtonPanel: true, // Show the button panel with Today and Done buttons
            buttonText: "Select date", // Text for the datepicker button
            onClose: function(dateText, inst) {
                // Optionally, you can perform actions when the datepicker closes
                console.log("Date selected:", dateText);
            }
        });
    });
</script>
