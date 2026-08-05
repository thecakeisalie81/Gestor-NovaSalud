document.querySelectorAll(".js-inactivar-admin").forEach((btn) => {
  btn.addEventListener("click", async () => {
    // 🔐 Validación clave
    if (totalAdminsActivos <= 1) {
      alert("Debe existir al menos un administrador activo en el sistema.");
      return;
    }

    if (!confirm("¿Deseas marcar este administrador como inactivo?")) return;

    const res = await fetch(
      "http://localhost/Gestor-NovaSalud/api/administradores.php",
      {
        method: "DELETE",
        credentials: "include",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id: btn.dataset.id }),
      },
    );

    const result = await res.json();

    if (result.success) {
      alert("✅ Administrador Desactivado");
      location.reload();
    } else {
      alert(result.error || "No se pudo desactivar el administrador");
    }
  });
});
