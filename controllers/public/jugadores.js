document.addEventListener("DOMContentLoaded", function() {
    const jugadoresContainer = document.getElementById('jugadores-container');

    // Array con los nombres de las imágenes de los jugadores
    const jugadores = ['jugador1.jpg', 'jugador2.jpg', 'jugador3.jpg', 'jugador4.jpg'];

    // Iterar sobre cada jugador y crear una card con la imagen y el texto
    jugadores.forEach(jugador => {
        const cardDiv = document.createElement('div');
        cardDiv.classList.add('card');

        const imagen = document.createElement('img');
        imagen.src = '../../resources/img/jugadores/' + jugador;

        const texto = document.createElement('p');
        texto.textContent = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';

        cardDiv.appendChild(imagen);
        cardDiv.appendChild(texto);
        jugadoresContainer.appendChild(cardDiv);
    });
});
