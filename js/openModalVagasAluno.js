document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("modal");
  const closeModal = document.querySelector(".close");
  const confirmButton = document.getElementById("confirmar");
  const fileInput = document.getElementById("curriculo");
  const uploadForm = document.getElementById("uploadForm");

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
/*
  uploadForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const file = fileInput.files[0];
    if (!file) {
      alert("Selecione um arquivo antes de enviar.");
      return;
    }

    const formData = new FormData();
    formData.append("curriculo", file);

    //local php
    fetch("../backend/seu-arquivo.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        alert(data.message);
        modal.style.display = "none";
      })
      .catch((error) => console.error("Erro ao enviar arquivo:", error));
  });
  */
});
