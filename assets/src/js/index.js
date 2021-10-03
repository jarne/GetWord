/**
 * GetWord | client side API script
 */

const passwordDisplay = document.getElementById("passwordDisplay");

const length = document.getElementById("length");
const letters = document.getElementById("letters");
const numbers = document.getElementById("numbers");
const specialChars = document.getElementById("specialCharts");
const easyToRem = document.getElementById("easyToRem");

const copyBtn = document.getElementById("copyBtn");
const regenBtn = document.getElementById("regenBtn");

function buildCall(length, letters, numbers, specialChars, easyToRem) {
    return (
        "/api/" +
        length +
        "/" +
        letters +
        "/" +
        numbers +
        "/" +
        specialChars +
        "/" +
        easyToRem
    );
}

function generate() {
    passwordDisplay.innerText = "...";

    fetch(
        buildCall(
            length.value,
            letters.value,
            numbers.value,
            specialChars.value,
            easyToRem.checked
        )
    )
        .then((resp) => resp.json())
        .then((json) => {
            if (json.status === "success") {
                passwordDisplay.innerText = json.generatedPassword;

                return;
            }

            alert("An unknown error occurred!");
        })
        .catch(() => {
            alert("An unknown error occurred!");
        });
}

length.onchange = generate;
letters.onchange = generate;
numbers.onchange = generate;
specialChars.onchange = generate;
easyToRem.onchange = generate;
regenBtn.onclick = generate;

copyBtn.onclick = () => {
    navigator.clipboard.writeText(passwordDisplay.innerText);
};

generate();
