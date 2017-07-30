/**
 * Created by jarne on 13.11.16.
 */

function fetch() {
    var length = $("#length").val();
    var useLetters = $("#useLetters").val();
    var useNumbers = $("#useNumbers").val();
    var useSpecialCharacters = $("#useSpecialCharacters").val();
    var easyToRemember = $("#easyToRemember").is(":checked");

    $("#result").html("");
    $("#loading").show();

    $.ajax({
        type: "GET",
        url: "/api/" + length + "/" + useLetters + "/" + useNumbers + "/" + useSpecialCharacters + "/" + easyToRemember,
        success: function(data) {
            if(data.status === "success") {
                $("#loading").hide();
                $("#result").html(data.generatedPassword);
            } else {
                $("#loading").hide();
            }
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