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
        link: "paciente/dashboard.php",
      },
      { icon: "bx bx-book-add", text: "Mis citas", link: "paciente/citas.php" },
    ],
    doctor: [
      {
        icon: "bx bx-home-heart",
        text: "Dashboard",
        link: "doctor/dashboard.php",
      },
      {
        icon: "bx bx-book-add",
        text: "Asignar cita",
        link: "doctor/asignar.php",
      },
      {
        icon: "bx bx-male-female",
        text: "Pacientes",
        link: "doctor/pacientes.php",
      },
    ],
    admin: [
      {
        icon: "bx bx-home-heart",
        text: "Dashboard",
        link: "admin/dashboard.php",
      },
      {
        icon: "bx bx-male-female",
        text: "Doctores",
        link: "admin/doctores.php",
      },
      { icon: "bx bx-user", text: "Usuarios", link: "admin/usuarios.php" },
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
