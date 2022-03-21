const modal = document.querySelector("#modal");
const openModal = document.querySelector(".open-button");
const closeModal = document.querySelector(".close");
const submitForm = document.querySelector("#submitForm")

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
        alert("Title: " + title + " // Desc: " + desc);
    } else {
        alert("Please fill everything up!");

    }
})

