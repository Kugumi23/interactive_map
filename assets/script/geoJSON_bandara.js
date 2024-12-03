map.createPane('geojsonPane');
    map.getPane('geojsonPane').style.zIndex = 700;
    
    var geo_bandara = "<?php echo base_url().'assets/script/bandara_supadio2.geojson'; ?>";

    fetch(geo_bandara)
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("GeoJSON Data:", data); // Debug data GeoJSON
        L.geoJSON(data, {
            pane: 'geojsonPane',
            style: function (feature) {
                return {
                    color: "white",
                    weight: 3,
                    opacity: 0.8,
                    dashArray:"8, 8",
                    fillColor: "orange",
                    fillOpacity: 0.2
                };
            },
            onEachFeature: function (feature, layer) {
                layer.bindPopup("International Airport Supadio");
            }
        }).addTo(map);
    })
    .catch(error => console.error("Error loading GeoJSON:", error));