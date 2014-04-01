function validateEmail(checkout, email) {

				// check email for null values
				var email = document.register.email.value;

				if (email == null || email == "") {

					window.alert("Email is a required field!");

					// set focus to form field
					document.getElementById('email').focus();

					return "";

				}

				// regular expression to check format of email address
				var regexObj = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

				// declare address
				var emailAddress = document.register.email.value;

				// if address enterd is not proper format display alert
				if (regexObj.test(emailAddress) == false) {

					alert('Invalid Email Address');

					// set focus to form field
					document.getElementById('email').focus();

					return "";

				} else {

					return document.register.email.value;

				}
			}

// function to titlecase string
			function toTitleCase(str) {

				return str.replace(/\w\S*/g, function(txt) {

					// return string in title case
					return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();

				});
			}

			// function to capitalize string
			function toUpperCase(str) {

				// return string capitalized
				return str.replace(/\w\S*/g, function(txt) {

					return txt.toUpperCase();

				});
			}