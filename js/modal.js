const modal = document.querySelector("#Termsmodal");
const openModal = document.querySelector(".open-button");
const closeModal = document.querySelector(".close");
const submitForm = document.querySelector("#submitForm");
const userID = document.getElementById("user-id").value;


openModal.addEventListener("click", () => {
    modal.showModal();
});

closeModal.addEventListener("click", () => {
    modal.close();
});

submitForm.addEventListener("click", () => {

    var title = document.getElementById("title").value;
    var desc = document.getElementById("description").value;
    if (title && desc) {
        if ((/^(?:\b\w+\b[\s\r\n]*){1,2}$/.test(title))) {
            window.location.replace("insertTermsAction.php?id=" + userID + "&title=" + title + "&description=" + desc);
        } else {
            alert("Title can have no more than 2 words!");
        }
    } else {
        alert("Please fill everything up!");
    }
})