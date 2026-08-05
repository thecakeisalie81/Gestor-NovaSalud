document.querySelectorAll(".js-inactivar-doctor").forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    e.stopPropagation();

    const id = btn.dataset.id;
    if (!confirm("¿Marcar doctor como INACTIVO?")) return;

    try {
      const res = await fetch(
        "http://localhost/Gestor-NovaSalud/api/doctores.php",
        {
          method: "DELETE",
          credentials: "include", // 🔥 sesión admin
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ id }),
        },
      );

      const result = await res.json();

      if (result.success) {
        alert("Doctor marcado como inactivo");
        location.reload(); // o quita la fila del DOM
      } else {
        alert(result.error || "Error al marcar como inactivo");
      }
    } catch (err) {
      console.error(err);
      alert("Error de conexión con el servidor");
    }
  });
});
