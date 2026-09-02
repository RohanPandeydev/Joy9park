jQuery(document).ready(function ($) {
  $("#commentform").on("submit", function (e) {
    var error = false;
    var errorMessage = "";

    var name = $("#author").val().trim();
    var email = $("#email").val().trim();
    var website = $("#url").val().trim();
    var comment = $("#comment").val().trim();

    // Name validation
    if (name === "") {
      error = true;
      errorMessage += "Name is required.\n";
    }

    // Email validation
    var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email === "" || !emailPattern.test(email)) {
      error = true;
      errorMessage += "Valid email is required.\n";
    }

    // Website validation (optional, must be a valid URL if provided)
    var urlPattern =
      /^(https?:\/\/)?([\da-z.-]+)\.([a-z.]{2,6})([/\w.-]*)*\/?$/;
    if (website !== "" && !urlPattern.test(website)) {
      error = true;
      errorMessage += "Enter a valid website URL (or leave blank).\n";
    }

    // Comment validation
    if (comment === "") {
      error = true;
      errorMessage += "Comment cannot be empty.\n";
    }

    // Block form submission if validation fails
    if (error) {
      alert(errorMessage);
      e.preventDefault(); // Stop default form submission
    }
  });
});
