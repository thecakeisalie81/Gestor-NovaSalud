document
  .getElementById("formCrearCita")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const data = {
      fecha: document.getElementById("fecha").value,
      hour: document.getElementById("hora").value,
      doctor: document.getElementById("doctor").value,
      description: document.getElementById("descripcion").value,
      state: "pendiente",
    };

    fetch("http://localhost/Proyecto_Backend/api/citas.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((res) => res.json())
      .then((response) => {
        if (response.success) {
          alert("✅ Cita creada correctamente");
          document.getElementById("formCrearCita").reset();
        } else {
          alert("❌ Error: " + response.error);
        }
      })
      .catch((error) => {
        console.error(error);
        alert("❌ Error al conectar con el servidor");
      });
  });
