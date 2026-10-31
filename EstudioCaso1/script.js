const students = [
    { nombre: "Maria", apellidos: "Mora Perez", nota: 90 },
    { nombre: "Pedro", apellidos: "Sibaja Lopez", nota: 60 },
    { nombre: "Marco", apellidos: "Rojas Castro", nota: 78 }
];

const form = document.getElementById("student-form");
const tbody = document.getElementById("students-body");
const errorMsg = document.getElementById("error-msg");
const maxNote = document.getElementById("max-note");
const avgNote = document.getElementById("avg-note");
const minNote = document.getElementById("min-note");

function renderTable() {
    tbody.innerHTML = "";
    students.forEach(function (student) {
        const row = document.createElement("tr");

        const cellNombre = document.createElement("td");
        cellNombre.textContent = student.nombre;

        const cellApellidos = document.createElement("td");
        cellApellidos.textContent = student.apellidos;

        const cellNota = document.createElement("td");
        const badge = document.createElement("span");
        badge.textContent = student.nota;

        if (student.nota >= 80) {
            badge.classList.add("nota-alta");
        } else if (student.nota < 65) {
            badge.classList.add("nota-baja");
        }

        cellNota.appendChild(badge);
        row.appendChild(cellNombre);
        row.appendChild(cellApellidos);
        row.appendChild(cellNota);
        tbody.appendChild(row);
    });
}

function updateSummary() {
    const notas = students.map(function (s) { return s.nota; });
    const max = Math.max.apply(null, notas);
    const min = Math.min.apply(null, notas);
    const sum = notas.reduce(function (a, b) { return a + b; }, 0);
    const avg = (sum / notas.length).toFixed(2);

    const bestStudent = students.find(function (s) { return s.nota === max; });
    maxNote.textContent = bestStudent.nombre + " " + bestStudent.apellidos + " (" + max + ")";
    avgNote.textContent = avg;
    minNote.textContent = min;
}

form.addEventListener("submit", function (e) {
    e.preventDefault();

    const nombre = document.getElementById("nombre").value.trim();
    const apellidos = document.getElementById("apellidos").value.trim();
    const notaValue = document.getElementById("nota").value.trim();

    if (nombre === "" || apellidos === "" || notaValue === "") {
        errorMsg.textContent = "Todos los campos son obligatorios.";
        return;
    }

    const nota = Number(notaValue);

    if (isNaN(nota) || nota < 0 || nota > 100) {
        errorMsg.textContent = "La nota debe ser un número entre 0 y 100.";
        return;
    }

    errorMsg.textContent = "";

    students.push({ nombre: nombre, apellidos: apellidos, nota: nota });

    renderTable();
    updateSummary();

    form.reset();
});

renderTable();
updateSummary();
