document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".btn-aprobado").forEach((btn) => {
    btn.addEventListener("click", () => {
      actualizarEstado(btn.dataset.id, "confirmada");
    });
  });

  document.querySelectorAll(".btn-noaprobado").forEach((btn) => {
    btn.addEventListener("click", () => {
      actualizarEstado(btn.dataset.id, "cancelada");
    });
  });
});

function actualizarEstado(id, estado) {
  fetch("http://localhost/Gestor-NovaSalud/api/citas.php", {
    method: "PUT", // usamos POST
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      id: id,
      state: estado,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Cita actualizada a: " + estado);
        location.reload();
      } else {
        alert(data.error || "Error al actualizar la cita");
      }
    })
    .catch((err) => {
      console.error(err);
      alert("Error de conexión con la API");
    });
}
