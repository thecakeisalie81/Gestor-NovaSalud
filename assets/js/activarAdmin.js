document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".js-activar-admin").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;

      if (!confirm("¿Deseas activar este administrador?")) return;

      fetch("http://localhost/Proyecto_Backend/api/administradores.php", {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        credentials: "same-origin",
        body: JSON.stringify({
          accion: "cambiar_estado",
          id: id,
        }),
      })
        .then((res) => res.json())
        .then((data) => {
          if (data.success) {
            alert("✅ Administrador activado");
            location.reload();
          } else {
            alert("❌ " + data.error);
          }
        })
        .catch((err) => {
          console.error(err);
          alert("❌ Error de conexión");
        });
    });
  });
});
