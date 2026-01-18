const items = [
  { name: "Dashboard", roles: ["admin", "editor", "viewer"] },
  { name: "Asignar cita", roles: ["admin"] },
  { name: "Reportes", roles: ["admin", "editor"] },
  { name: "Perfil", roles: ["admin", "editor", "viewer"] }
];

function renderSidebar(userRole) {
  return items
    .filter(item => item.roles.includes(userRole))
    .map(item => `<li>${item.name}</li>`)
    .join("");
}
