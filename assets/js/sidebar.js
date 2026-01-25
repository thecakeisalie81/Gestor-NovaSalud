const items = [
  { name: "Dashboard", roles: ["admin", "editor", "viewer"] },
  { name: "Asignar cita", roles: ["admin"] },
  { name: "Reportes", roles: ["admin", "editor"] },
  { name: "Perfil", roles: ["admin", "editor", "viewer"] },
];

function renderSidebar(userRole) {
  return items
    .filter((item) => item.roles.includes(userRole))
    .map((item) => `<li>${item.name}</li>`)
    .join("");
}

document.addEventListener("DOMContentLoaded", () => {
  const menuLinks = document.querySelector(".menu-links");

  // Carga difrentes paginas dependiendo del rol del usuario
  const menus = {
    paciente: [
      {
        icon: "bx bx-home-heart",
        text: "Dashboard",
        link: "./dashboard.php",
      },
      { icon: "bx bx-book-add", text: "Mis citas", link: "./mis_citas.php" },
    ],
    doctor: [
      {
        icon: "bx bx-home-heart",
        text: "Dashboard",
        link: "./dashboard.php",
      },
      {
        icon: "bx bx-book-add",
        text: "Asignar cita",
        link: "./asignar_cita.php",
      },
      {
        icon: "bx bx-male-female",
        text: "Calendario de citas",
        link: "./citas_asignadas.php",
      },
    ],
    admin: [
      {
        icon: "bx bx-home-heart",
        text: "Dashboard",
        link: "./dashboard.php",
      },
      {
        icon: "bx bx-male-female",
        text: "Doctores",
        link: "./doctores.php",
      },
      { icon: "bx bx-user", text: "Pacientes", link: "./usuarios.php" },
    ],
  };

  // Limpiar menú actual
  menuLinks.innerHTML = "";

  // Agregar items según rol
  if (menus[userRole]) {
    menus[userRole].forEach((item) => {
      const li = document.createElement("li");
      li.classList.add("nav-link");
      li.innerHTML = `
        <a href="${item.link}">
          <i class='${item.icon} icon'></i>
          <span class="text nav-text">${item.text}</span>
        </a>
      `;
      menuLinks.appendChild(li);
    });
  }
});
