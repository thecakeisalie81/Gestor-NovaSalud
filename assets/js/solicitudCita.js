document
  .getElementById("formCrearCita")
  .addEventListener("submit", function (e) {
    e.preventDefault();

    const data = {
      fecha: document.getElementById("fecha").value,
      hour: document.getElementById("hora").value,
      description: document.getElementById("descripcion").value,
      state: "pendiente",
    };

    // Paciente selecciona doctor
    const doctorField = document.getElementById("doctor");
    if (doctorField) {
      data.doctor = doctorField.value;
    }

    // Doctor selecciona paciente
    const pacienteField = document.getElementById("paciente");
    if (pacienteField) {
      data.paciente = pacienteField.value;
    }

    console.log("Datos enviados:", data); // <-- para depurar

    fetch("http://localhost/Gestor-NovaSalud/api/citas.php", {
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
