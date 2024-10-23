let map;

async function initMap() {
  const { Map } = await google.maps.importLibrary("maps");

  // Initialize the map
  map = new Map(document.getElementById("map"), {
    center: { lat: 34.644, lng: -97.161 },
    zoom: 15,
  });

  // Create the KML layer
  const kmlLayer = new google.maps.KmlLayer({
    url: "https://raw.githubusercontent.com/DarthLiam93/Test-area/refs/heads/test-branch/WynnewoodPrimaryLines.kml",
    suppressInfoWindows: false,
    preserveViewport: false,
    map: map
  });
}

initMap();
