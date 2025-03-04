document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");
  const closeModal = document.querySelector(".close");

  document.querySelectorAll(".buttons button").forEach((button) => {
    button.addEventListener("click", function () {
      const idVaga = this.dataset.idVaga;

      document.getElementById("idvaga").value = idVaga;

      modal.style.display = "flex";
    });
  });

  closeModal.addEventListener("click", function () {
    modal.style.display = "none";
  });

  window.addEventListener("click", function (event) {
    if (event.target === modal) {
      modal.style.display = "none";
    }
  });
});
