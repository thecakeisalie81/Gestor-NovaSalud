document.querySelectorAll(".js-activar-doctor").forEach((btn) => {
  btn.addEventListener("click", async (e) => {
    e.stopPropagation();

    const id = btn.dataset.id;
    if (!confirm("¿Marcar doctor como ACTIVO?")) return;

    const res = await fetch(
      "http://localhost/Gestor-NovaSalud/api/doctores.php",
      {
        method: "PUT",
        credentials: "include",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id, activar: true }),
      },
    );

    const result = await res.json();

    if (result.success) {
      alert("Doctor marcado como Activo");
      location.reload();
    } else {
      console.error(err);
      alert("Error de conexión con el servidor");
    }
  });
});
