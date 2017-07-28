/**
 * Created by jarne on 13.11.16.
 */

function fetch() {
    var length = $("#length").val();
    var useLetters = $("#useLetters").is(":checked");
    var useNumbers = $("#useNumbers").is(":checked");
    var useSpecialCharacters = $("#useSpecialCharacters").is(":checked");
    var easyToRemember = $("#easyToRemember").is(":checked");

    $("#result").html("<div class=\"spinner\"> </div>");

    $.ajax({
        type: "GET",
        url: "/api/" + length + "/" + useLetters + "/" + useNumbers + "/" + useSpecialCharacters + "/" + easyToRemember,
        success: function(data) {
            if(data.status === "success") {
                $("#result").html(data.generatedPassword);
            } else {
                $("#result").html("");
            }
        },
        failed: function() {
            $("#result").html("");
        }
    });
}

$(document).ready(function() {
    fetch();
});

$("#length").change(function() {
    fetch();
});

$("#useLetters").change(function() {
    fetch();
});

$("#useNumbers").change(function() {
    fetch();
});

$("#useSpecialCharacters").change(function() {
    fetch();
});

$("#easyToRemember").change(function() {
    fetch();
});