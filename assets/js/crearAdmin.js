document.addEventListener("DOMContentLoaded", () => {
  const abrirBtn = document.querySelector(".js-abrir-crear-admin");
  const modal = document.getElementById("modalCrearAdmin");
  const cerrarBtn = document.getElementById("cerrarCrearAdmin");
  const form = document.getElementById("formCrearAdmin");

  if (!abrirBtn || !modal || !cerrarBtn || !form) {
    console.error("❌ Elementos del modal no encontrados");
    return;
  }

  abrirBtn.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  cerrarBtn.addEventListener("click", () => {
    modal.style.display = "none";
  });

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
      name: document.getElementById("create_name").value,
      age: document.getElementById("create_age").value,
      phone: document.getElementById("create_phone").value,
      email: document.getElementById("create_email").value,
      pass: document.getElementById("create_pass").value,
      rol: "admin",
    };

    console.log("📤 Enviando:", data);

    try {
      const res = await fetch(
        "http://localhost/Gestor-NovaSalud/api/administradores.php",
        {
          method: "POST",
          credentials: "include",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(data),
        },
      );

      const result = await res.json();
      console.log("📥 Respuesta:", result);

      if (res.ok && result.success) {
        alert("Administrador creado correctamente");
        location.reload();
      } else {
        alert(result.error || "No se pudo crear el administrador");
      }
    } catch (error) {
      console.error("🔥 Error en fetch:", error);
      alert("Error de conexión con el servidor");
    }
  });
});
