document
  .getElementById("formCrearCita")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const data = {
      fecha: document.getElementById("fecha").value,
      hour: document.getElementById("hora").value + ":00", // TIME → 09:00:00
      paciente: document.getElementById("paciente").value,
      state: "confirmada",
      description: document.getElementById("descripcion").value,
    };

    fetch("http://localhost/Proyecto_Backend/api/citas.php", {
      method: "POST",
      credentials: "same-origin", // 🔥 CLAVE
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((resp) => {
        if (resp.success) {
          alert("Cita creada correctamente");
          document.getElementById("formCrearCita").reset();
        } else {
          alert(resp.error || "Error al crear la cita");
        }
      })
      .catch((err) => {
        console.error(err);
        alert("Error de conexión");
      });
  });
