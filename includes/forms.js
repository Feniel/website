function formhash(form, password) {
    // Erstelle ein neues Feld für das gehashte Passwort.
    var p = document.createElement("input");

    // Füge es dem Formular hinzu.
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    // Sorge dafür, dass kein Text-Passwort geschickt wird.
    password.value = "";

    // Reiche das Formular ein.
    form.submit();
}