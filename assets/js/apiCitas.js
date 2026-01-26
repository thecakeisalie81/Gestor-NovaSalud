fetch("http://localhost/Proyecto_Backend/api/citas.php", {
  method: "POST",
  credentials: "same-origin",
  headers: {
    "Content-Type": "application/json",
  },
  body: JSON.stringify(data),
});
