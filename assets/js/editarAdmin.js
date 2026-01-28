document.addEventListener("DOMContentLoaded", () => {
  // ABRIR MODAL Y CARGAR DATOS
  document.querySelectorAll(".js-editar-admin").forEach((btn) => {
    btn.addEventListener("click", () => {
      document.getElementById("edit_admin_id").value = btn.dataset.id;
      document.getElementById("edit_admin_name").value = btn.dataset.name;
      document.getElementById("edit_admin_age").value = btn.dataset.age;
      document.getElementById("edit_admin_phone").value = btn.dataset.phone;
      document.getElementById("edit_admin_email").value = btn.dataset.email;

      document.getElementById("modalEditarAdmin").style.display = "flex";
    });
  });

  // CERRAR MODAL
  document.getElementById("cerrarModalAdmin").addEventListener("click", () => {
    document.getElementById("modalEditarAdmin").style.display = "none";
  });

  // ENVIAR FORMULARIO
  document.getElementById("formEditarAdmin").addEventListener("submit", (e) => {
    e.preventDefault();

    const data = {
      id: document.getElementById("edit_admin_id").value,
      name: document.getElementById("edit_admin_name").value,
      age: document.getElementById("edit_admin_age").value,
      phone: document.getElementById("edit_admin_phone").value,
      email: document.getElementById("edit_admin_email").value,
    };

    fetch("http://localhost/Proyecto_Backend/api/administradores.php", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      credentials: "same-origin",
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.success) {
          alert("✅ Administrador actualizado");
          location.reload();
        } else {
          alert("❌ Error: " + response.error);
        }
      })
      .catch((err) => {
        console.error(err);
        alert("❌ Error de conexión");
      });
  });
});
