document.addEventListener('DOMContentLoaded', function () {
    const userPosition = document.getElementById('position').innerHTML;
    console.log(userPosition);

    switch (userPosition) {
        case 'Webadmin':
            document.getElementById('Webadmin').style.display = "block";
            fetch('../../SKV/module/mitgliederbereich/webadmin.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('Webadmin').innerHTML = data;
                });
        case 'Vorstand':
            document.getElementById('Vorstand').style.display = "block";
            fetch('../../SKV/module/mitgliederbereich/vorstand.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('Vorstand').innerHTML = data;
                });
        case 'ER':
            document.getElementById('ER').style.display = "block";
            fetch('../../SKV/module/mitgliederbereich/er.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('ER').innerHTML = data;
                });
        case 'PK':
            document.getElementById('PK').style.display = "block";
            fetch('../../SKV/module/mitgliederbereich/pk.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('PK').innerHTML = data;
                });
            break;
    };
});