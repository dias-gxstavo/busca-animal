  // Lista de locais de apoio animal, inseridos manualmente
  const locaisDeApoio = [
    {
        nome: 'SUIPA - Sociedade União Internacional Protetora dos Animais',
        latitude: -22.8836, 
        longitude: -43.2540
    },
    {
        nome: 'CAARP',
        latitude: -22.8442,
        longitude: -43.2891
    },
    {
        nome: 'Resgates dos Dog Rio',
        latitude: -22.9161, 
        longitude: -43.1778
    },
    {
        nome: 'Amigo Não se Compra',
        latitude: -22.9150,
        longitude: -43.1869
    },
    {
        nome: 'ONG Garra Animal',
        latitude: -22.9418,
        longitude: -43.6426
    },
    {
        nome: 'UIPA - União Internacional Protetora dos Animais',
        latitude:  -23.5202,
        longitude: -46.6222
    },
    {
        nome: 'Instituto Eu Sou o Bicho',
        latitude:  -23.5024,
        longitude: -46.5828
    },
    {
        nome: 'Associação Protetora de Animais São Francisco de Assis',
        latitude:  -23.5129,
        longitude: -46.5920
    },
    {
        nome: 'Vira-Lata é Dez',
        latitude:  -23.5386,
        longitude: -46.7289
    },
    {
        nome: 'Associação do Amigo Animal',
        latitude:  -25.4355,  
        longitude: -49.3573
    },
    {
        nome: 'Sociedade Protetora dos Animais de Curitiba',
        latitude:  -25.3733,  
        longitude: -49.2207
    },
    {
        nome: 'Quatro Patas',
        latitude:  -25.4291, 
        longitude: -49.2819
    },
    {
        nome: 'CRAR - Centro de Referência para Animais em risco',
        latitude: -25.4725, 
        longitude: -49.3605
    },
    {
        nome: 'Cãoviver',
        latitude: -19.8531,
        longitude: -44.0111
    },
    {
        nome: 'Ong Focinho Carente',
        latitude:  -20.6988, 
        longitude:  -44.8481
    },
    {
        nome: 'APA - Associação Protetora de Animais',
        latitude:  -18.9693, 
        longitude: -48.3581
    },

];

// Adiciona os marcadores ao mapa
locaisDeApoio.forEach(local => {
    
// Cria o marcador para cada local
 const marker = new maplibregl.Marker()
 .setLngLat([local.longitude, local.latitude]) // Define a posição do marcador
 .addTo(map); // Adiciona o marcador ao mapa

    // Cria o popup com o nome da instituição
    const popup = new maplibregl.Popup({ offset: 25 }) // Offset para ajustar a posição do popup
        .setText(local.nome); // Define o conteúdo do popup

    // Associa o popup ao marcador
    marker.setPopup(popup);
});