function weiterleitenUndÜbergeben(zuURL, name, stringWert) {
    // Speichere den String im sessionStorage
    sessionStorage.setItem(name, stringWert);

    // Weiterleitung zur neuen URL
    window.location.href = zuURL;
}