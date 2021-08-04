function initMap() {
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: { lat: -25.344, lng: 131.036 },
    });

    const body = document.querySelector('body');

    const harbors = JSON.parse(body.dataset.harbors);

    for (let i=0; i<harbors.length; i++) {
        const harbor = harbors[i];
        const infoWindow = new google.maps.InfoWindow({
            content: harbor['name'],
        });

        const marker = new google.maps.Marker({
            position: { lat: parseFloat(harbor['lat']), lng: parseFloat(harbor['lon']) },
            map: map,
        });

        marker.addListener('click', () => {
            infoWindow.open({
                anchor: marker,
                map,
                shouldFocus: false,
            });
        });
    }
}