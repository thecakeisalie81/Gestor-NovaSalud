// ABRIR MODAL
document
  .querySelector(".js-abrir-crear-doctor")
  .addEventListener("click", (e) => {
    e.stopPropagation();
    document.getElementById("modalCrearDoctor").style.display = "flex";
  });

// CERRAR MODAL
document.getElementById("cerrarCrearDoctor").addEventListener("click", (e) => {
  e.stopPropagation();
  document.getElementById("modalCrearDoctor").style.display = "none";
});

// ENVIAR POST
document
  .getElementById("formCrearDoctor")
  .addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
      name: document.getElementById("create_name").value,
      age: document.getElementById("create_age").value,
      phone: document.getElementById("create_phone").value,
      email: document.getElementById("create_email").value,
      specialty: document.getElementById("create_specialty").value,
      pass: document.getElementById("create_pass").value,
      rol: "doctor",
    };

    const res = await fetch(
      "http://localhost/Proyecto_Backend/api/doctores.php",
      {
        method: "POST",
        credentials: "include", // 🔐 sesión admin
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      },
    );

    const result = await res.json();

    if (result.success) {
      alert("Doctor creado correctamente");
      location.reload();
    } else {
      alert(result.error || "Error al crear doctor");
    }
  });
