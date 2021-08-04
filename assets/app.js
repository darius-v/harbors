/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Initialize and add the map
function initMap() {

    // The location of Uluru
    const uluru = { lat: -25.344, lng: 131.036 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 4,
        center: uluru,
    });

    const body = document.querySelector('body');

    const harbors = JSON.parse(body.dataset.harbors);
    // console.log( harbors.length);
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