/**
 * Campus Location Map Component with Leaflet & Geolocation Routing
 * Directs users to the chosen campus in Dasmariñas, Cavite
 */

const CAMPUS_GEO = {
    'DLSU-D': {
        lat: 14.3242,
        lng: 120.9586,
        name: 'De La Salle University - Dasmariñas',
        address: 'Congressional Ave, Burol 2, Dasmariñas City, Cavite',
        googleQuery: 'De La Salle University Dasmariñas'
    },
    'CvSU': {
        lat: 14.3276,
        lng: 120.9499,
        name: 'Cavite State University - Dasmariñas Learning Center',
        address: 'Gov. D. Mangubat Blvd, Burol Main, Dasmariñas City, Cavite',
        googleQuery: 'Cavite State University Dasmariñas Learning Center'
    },
    'EAC-C': {
        lat: 14.3245,
        lng: 120.9462,
        name: 'Emilio Aguinaldo College - Cavite',
        address: 'Gov. D. Mangubat Blvd / Congressional East Ave, Burol Main, Dasmariñas City, Cavite',
        googleQuery: 'Emilio Aguinaldo College Cavite'
    },
    'NCST': {
        lat: 14.3279,
        lng: 120.9415,
        name: 'National College of Science and Technology',
        address: 'Emilio Aguinaldo Hwy, Zone 4, Dasmariñas City, Cavite',
        googleQuery: 'National College of Science and Technology Dasmariñas'
    },
    'PCU': {
        lat: 14.2889,
        lng: 120.9638,
        name: 'Philippine Christian University - Dasmariñas',
        address: 'Emilio Aguinaldo Hwy, Sampaloc 1, Dasmariñas City, Cavite',
        googleQuery: 'Philippine Christian University Dasmariñas'
    },
    'TUP': {
        lat: 14.3458,
        lng: 120.9659,
        name: 'Technological University of the Philippines - Cavite',
        address: 'Carlos Q. Trinidad Ave, Salawag, Dasmariñas City, Cavite',
        googleQuery: 'Technological University of the Philippines Cavite'
    },
    'FEAPITSAT': {
        lat: 14.3262,
        lng: 120.9452,
        name: 'FEAPITSAT Colleges',
        address: 'Congressional East Ave, Burol Main, Dasmariñas City, Cavite',
        googleQuery: 'FEAPITSAT Colleges Dasmariñas'
    },
    'PHINMA': {
        lat: 14.3385,
        lng: 120.9402,
        name: 'PHINMA Union College of Laguna (Dasma)',
        address: 'Dasmariñas City, Cavite',
        googleQuery: 'PHINMA Union College of Laguna Dasmariñas'
    },
    'STI': {
        lat: 14.3288,
        lng: 120.9387,
        name: 'STI College Dasmariñas',
        address: 'Emilio Aguinaldo Hwy, Zone 4, Dasmariñas City, Cavite',
        googleQuery: 'STI College Dasmariñas'
    },
    'KLD': {
        lat: 14.3228,
        lng: 120.9501,
        name: 'Kolehiyo ng Lungsod ng Dasmariñas',
        address: 'Burol Main, Dasmariñas City, Cavite',
        googleQuery: 'Kolehiyo ng Lungsod ng Dasmariñas'
    },
    'NU': {
        lat: 14.3012,
        lng: 120.9578,
        name: 'National University - Dasmariñas',
        address: 'SM City Dasmariñas Complex, Dasmariñas City, Cavite',
        googleQuery: 'National University Dasmariñas'
    },
    'PNTC': {
        lat: 14.3268,
        lng: 120.9365,
        name: 'PNTC Colleges - Dasmariñas',
        address: 'Zone 3, Dasmariñas City, Cavite',
        googleQuery: 'PNTC Colleges Dasmariñas'
    }
};

let activeCampusMap = null;

function initSchoolLocationMap(college) {
    const mapSection = document.getElementById('map-section');
    if (!mapSection) return;
    mapSection.classList.remove('hidden');

    // Determine target campus geo
    let geo = null;
    if (college.latitude && college.longitude && !isNaN(parseFloat(college.latitude)) && !isNaN(parseFloat(college.longitude))) {
        geo = {
            lat: parseFloat(college.latitude),
            lng: parseFloat(college.longitude),
            name: college.name || 'Campus Grounds',
            address: college.address || 'Dasmariñas City, Cavite'
        };
    } else if (college.short_name && CAMPUS_GEO[college.short_name]) {
        geo = CAMPUS_GEO[college.short_name];
    } else if (college.name) {
        for (const key in CAMPUS_GEO) {
            if (college.name.toLowerCase().includes(key.toLowerCase()) || 
                CAMPUS_GEO[key].name.toLowerCase().includes(college.name.toLowerCase())) {
                geo = CAMPUS_GEO[key];
                break;
            }
        }
    }
    if (!geo) {
        geo = {
            lat: 14.3294,
            lng: 120.9367,
            name: college.name || 'Campus Grounds',
            address: college.address || 'City of Dasmariñas, Cavite'
        };
    }

    const schoolNameEl = document.getElementById('college-map-school-name');
    if (schoolNameEl) {
        schoolNameEl.textContent = college.name || geo.name;
    }

    const addressEl = document.getElementById('college-map-address');
    if (addressEl) {
        addressEl.textContent = college.address || geo.address;
    }

    let curLat = geo.lat;
    let curLng = geo.lng;
    let userLat = null;
    let userLng = null;

    const coordsDisplay = document.getElementById('map-coords-display');
    const mapLink = document.getElementById('college-map-link');

    function updateUrlAndCoords(lat, lng) {
        curLat = Number(Number(lat).toFixed(4));
        curLng = Number(Number(lng).toFixed(4));
        if (coordsDisplay) {
            coordsDisplay.textContent = `${curLat}, ${curLng}`;
        }
        if (mapLink) {
            if (userLat && userLng) {
                mapLink.href = `https://www.google.com/maps/dir/?api=1&origin=${userLat},${userLng}&destination=${curLat},${curLng}`;
            } else {
                mapLink.href = `https://www.google.com/maps/dir/?api=1&destination=${curLat},${curLng}`;
            }
        }
    }

    updateUrlAndCoords(curLat, curLng);

    const mapContainer = document.getElementById('school-leaflet-map');
    if (!mapContainer) return;

    if (typeof L === 'undefined') {
        if (!document.getElementById('leaflet-css')) {
            const link = document.createElement('link');
            link.id = 'leaflet-css';
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.appendChild(link);
        }
        if (!window.leafletLoadingPromise) {
            window.leafletLoadingPromise = new Promise((resolve, reject) => {
                const s = document.createElement('script');
                s.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
                s.onload = resolve;
                s.onerror = reject;
                document.head.appendChild(s);
            });
        }
        window.leafletLoadingPromise.then(() => {
            initSchoolLocationMap(college);
        }).catch(err => {
            console.error('Failed to load Leaflet:', err);
        });
        return;
    }

    if (activeCampusMap) {
        try { activeCampusMap.remove(); } catch(e){}
        activeCampusMap = null;
    }

    const map = L.map('school-leaflet-map', {
        zoomControl: false,
        attributionControl: false
    }).setView([curLat, curLng], 16);
    activeCampusMap = map;

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const schoolPinIcon = L.icon({
        iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
        iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41],
        className: 'school-marker-drop'
    });

    // School Marker (Draggable)
    const schoolMarker = L.marker([curLat, curLng], {
        icon: schoolPinIcon,
        draggable: true,
        title: college.name || geo.name
    }).addTo(map);

    schoolMarker.bindPopup(`
        <div style="font-family: inherit; font-size: 12px; line-height: 1.35; padding: 2px; min-width: 160px; max-width: 220px;">
            <div style="font-weight: 800; font-size: 13px; color: #111827; margin-bottom: 2px; word-break: break-word;">${college.name || geo.name}</div>
            <div style="font-size: 11px; color: #6b7280; line-height: 1.3; word-break: break-word;">${college.address || geo.address}</div>
        </div>
    `, {
        autoPan: true,
        autoPanPadding: [12, 12],
        closeButton: false,
        maxWidth: 230
    }).openPopup();

    try {
        schoolMarker.bindTooltip(`<b>${college.name || geo.name}</b>`, {
            permanent: true,
            direction: 'top',
            offset: [0, -38],
            className: 'school-pin-label'
        });
    } catch(e) {}

    schoolMarker.on('dragend', function() {
        const pos = schoolMarker.getLatLng();
        updateUrlAndCoords(pos.lat, pos.lng);
    });

    map.on('click', function(e) {
        schoolMarker.setLatLng(e.latlng);
        updateUrlAndCoords(e.latlng.lat, e.latlng.lng);
    });

    setTimeout(() => {
        map.invalidateSize();
        map.panBy([0, -30]);
    }, 250);

    // Geolocation handler
    const myLocBtn = document.getElementById('my-location-btn');
    const locatingText = document.getElementById('locating-text');
    let userMarker = null;
    let routeLine = null;

    if (myLocBtn) {
        myLocBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();

            if (!navigator.geolocation) {
                alert('Geolocation is not supported by your browser.');
                return;
            }

            if (locatingText) locatingText.textContent = 'Locating...';
            myLocBtn.classList.add('opacity-75', 'cursor-wait');

            navigator.geolocation.getCurrentPosition(
                function(pos) {
                    if (locatingText) locatingText.textContent = 'My location';
                    myLocBtn.classList.remove('opacity-75', 'cursor-wait');

                    userLat = Number(pos.coords.latitude.toFixed(4));
                    userLng = Number(pos.coords.longitude.toFixed(4));

                    if (userMarker) map.removeLayer(userMarker);
                    if (routeLine) map.removeLayer(routeLine);

                    const userRadarIcon = L.divIcon({
                        className: 'custom-user-radar',
                        html: `
                            <div style="position: relative; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                <div class="user-location-pulse"></div>
                                <div style="width: 14px; height: 14px; background: #2563eb; border: 2.5px solid #ffffff; border-radius: 50%; box-shadow: 0 2px 6px rgba(0,0,0,0.35); z-index: 2;"></div>
                            </div>
                        `,
                        iconSize: [28, 28],
                        iconAnchor: [14, 14]
                    });

                    userMarker = L.marker([userLat, userLng], {
                        icon: userRadarIcon,
                        zIndexOffset: 1000
                    }).addTo(map);
                    userMarker.bindPopup('<b>You are here</b>').openPopup();

                    routeLine = L.polyline([
                        [userLat, userLng],
                        [curLat, curLng]
                    ], {
                        color: '#2563eb',
                        weight: 4,
                        dashArray: '6, 8',
                        opacity: 0.85
                    }).addTo(map);

                    map.fitBounds([
                        [userLat, userLng],
                        [curLat, curLng]
                    ], { padding: [35, 35] });

                    updateUrlAndCoords(curLat, curLng);
                },
                function(err) {
                    if (locatingText) locatingText.textContent = 'My location';
                    myLocBtn.classList.remove('opacity-75', 'cursor-wait');
                    console.warn('Geolocation error:', err.message);
                    alert('Could not get your exact location. You can still tap "Open in Google Maps for exact route" to calculate directions from your current GPS position.');
                },
                { enableHighAccuracy: true, timeout: 10000, maximumAge: 60000 }
            );
        };
    }

    // Fullscreen toggle handler
    const fullscreenBtn = document.getElementById('fullscreen-map-btn');
    const mapBox = document.getElementById('school-map-box');
    const expandIcon = document.getElementById('fullscreen-expand-icon');
    const compressIcon = document.getElementById('fullscreen-compress-icon');
    let isFullscreen = false;

    function toggleFullscreen(enable) {
        if (!mapBox) return;
        if (typeof enable === 'boolean') {
            isFullscreen = enable;
        } else {
            isFullscreen = !isFullscreen;
        }

        if (isFullscreen) {
            mapBox.classList.add('map-fullscreen-active');
            if (expandIcon) expandIcon.style.display = 'none';
            if (compressIcon) compressIcon.style.display = 'block';
            if (fullscreenBtn) fullscreenBtn.setAttribute('title', 'Exit Fullscreen (Esc)');
            document.body.style.overflow = 'hidden';

            const fsName = document.getElementById('fs-school-name');
            const fsAddr = document.getElementById('fs-school-address');
            if (fsName) fsName.textContent = college.name || (geo ? geo.name : "Campus Grounds");
            if (fsAddr) fsAddr.textContent = college.address || (geo ? geo.address : "Dasmariñas City, Cavite");
            const fsBtn = document.getElementById('fs-google-maps-btn');
            if (fsBtn && mapLink) fsBtn.href = mapLink.href;
        } else {
            mapBox.classList.remove('map-fullscreen-active');
            if (expandIcon) expandIcon.style.display = 'block';
            if (compressIcon) compressIcon.style.display = 'none';
            if (fullscreenBtn) fullscreenBtn.setAttribute('title', 'Full Screen Map');
            document.body.style.overflow = '';
        }

        setTimeout(() => {
            map.invalidateSize();
            if (schoolMarker) {
                map.panTo(schoolMarker.getLatLng());
            }
        }, 150);
    }

    if (fullscreenBtn && mapBox) {
        fullscreenBtn.onclick = function(e) {
            e.preventDefault();
            e.stopPropagation();
            toggleFullscreen();
        };

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isFullscreen) {
                toggleFullscreen(false);
            }
        });
    }
}

window.initSchoolLocationMap = initSchoolLocationMap;

