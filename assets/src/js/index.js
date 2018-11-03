/**
 * GetWord | client side api script
 */

var passwordDisplay = $("#passwordDisplay");

var length = $("#length");
var letters = $("#letters");
var numbers = $("#numbers");
var specialChars = $("#specialCharts");
var easyToRem = $("#easyToRem");

function fetch() {
    passwordDisplay.html("");

    $.ajax({
        type: "GET",
        url: "/api/" + length.val() + "/" + letters.val() + "/" + numbers.val() + "/" + specialChars.val() + "/" + easyToRem.is(":checked"),
        success: function(data) {
            if(data.status === "success") {
                passwordDisplay.html(data.generatedPassword);
            } else {
                alert("An unknown error occurred!");
            }
        }
    });
}

length.change(fetch);
letters.change(fetch);
numbers.change(fetch);
specialChars.change(fetch);
easyToRem.change(fetch);

$(document).ready(fetch);
