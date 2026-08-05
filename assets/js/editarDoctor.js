document.querySelectorAll(".js-editar-doctor").forEach((btn) => {
  btn.addEventListener("click", (e) => {
    e.stopPropagation();

    document.getElementById("modalEditarDoctor").style.display = "flex";

    document.getElementById("edit_id").value = btn.dataset.id;
    document.getElementById("edit_name").value = btn.dataset.name;
    document.getElementById("edit_age").value = btn.dataset.age;
    document.getElementById("edit_phone").value = btn.dataset.phone;
    document.getElementById("edit_email").value = btn.dataset.email;
    document.getElementById("edit_specialty").value = btn.dataset.specialty;
  });
});

// cerrar modal
document.getElementById("cerrarModal").addEventListener("click", (e) => {
  e.stopPropagation();
  document.getElementById("modalEditarDoctor").style.display = "none";
});

// ENVIAR PUT
document
  .getElementById("formEditarDoctor")
  .addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
      id: document.getElementById("edit_id").value,
      name: document.getElementById("edit_name").value,
      age: document.getElementById("edit_age").value,
      phone: document.getElementById("edit_phone").value,
      email: document.getElementById("edit_email").value,
      specialty: document.getElementById("edit_specialty").value,
      rol: "doctor",
    };

    const res = await fetch(
      "http://localhost/Gestor-NovaSalud/api/doctores.php",
      {
        method: "PUT",
        credentials: "include",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      },
    );

    const result = await res.json();

    if (result.success) {
      alert("Doctor actualizado correctamente");
      location.reload();
    } else {
      alert(result.error || "Error al actualizar");
    }
  });
