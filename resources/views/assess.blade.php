<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assess Location - {{ config('app.name', 'GreenLens') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: radial-gradient(circle at top, #f8fdf7 0%, #eff6f1 45%, #dcefe3 100%);
            color: #0f172a;
            min-height: 100vh;
        }

        .form-container {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1.5rem;
            box-shadow: 0 25px 60px rgba(15, 23, 42, 0.1);
        }

        .form-header {
            background: linear-gradient(135deg, #176c4b 0%, #1a5f4a 100%);
            color: white;
            border-radius: 1.5rem 1.5rem 0 0;
            padding: 2rem;
            text-align: center;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .field-section {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            background: #fbfdfb;
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .form-label {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.55rem;
            display: block;
            font-size: 0.95rem;
        }

        .form-input {
            border: 1px solid rgba(15, 23, 42, 0.12);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            border-color: #176c4b;
            box-shadow: 0 0 0 3px rgba(23, 108, 75, 0.1);
            outline: none;
        }

        .input-helper {
            font-size: 0.875rem;
            color: #64748b;
            margin-top: 0.5rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, #176c4b 0%, #1a5f4a 100%);
            border: none;
            padding: 0.875rem 2rem;
            font-weight: 600;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(23, 108, 75, 0.2);
        }

        .btn-back {
            display: inline-block;
            margin-bottom: 2rem;
            color: #176c4b;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .btn-back:hover {
            color: #1a5f4a;
        }

        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #176c4b;
            padding: 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .info-box-title {
            font-weight: 600;
            color: #176c4b;
            margin-bottom: 0.5rem;
        }

        .info-box-text {
            color: #4b5563;
            font-size: 0.925rem;
            line-height: 1.5;
        }

        .search-panel {
            background: linear-gradient(180deg, #f8fcf9 0%, #eef8f1 100%);
            border: 1px solid rgba(23, 108, 75, 0.12);
            border-radius: 1rem;
            padding: 1.25rem;
        }

        .search-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 0.75rem;
        }

        .btn-search {
            border: 0;
            border-radius: 0.75rem;
            background: #176c4b;
            color: #fff;
            font-weight: 600;
            padding: 0.875rem 1.1rem;
        }

        .btn-search:hover {
            background: #14573d;
        }

        .search-status {
            min-height: 1.2rem;
            margin-top: 0.75rem;
            color: #64748b;
            font-size: 0.875rem;
        }

        .result-list {
            display: grid;
            gap: 0.75rem;
            margin-top: 1rem;
        }

        .result-item {
            width: 100%;
            text-align: left;
            border: 1px solid rgba(15, 23, 42, 0.08);
            background: #fff;
            border-radius: 0.85rem;
            padding: 0.95rem 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, transform 0.2s ease;
        }

        .result-item:hover {
            border-color: rgba(23, 108, 75, 0.25);
            box-shadow: 0 10px 24px rgba(23, 108, 75, 0.08);
            transform: translateY(-1px);
        }

        .result-title {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 0.25rem;
        }

        .result-meta {
            color: #64748b;
            font-size: 0.875rem;
            margin: 0;
        }

        .coords-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1rem;
        }

        .section-label {
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #176c4b;
            margin-bottom: 0.9rem;
        }

        .section-copy {
            font-size: 0.92rem;
            color: #64748b;
            margin-bottom: 1rem;
        }

        .field-stack {
            display: grid;
            gap: 1rem;
        }

        .input-shell {
            background: #ffffff;
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 0.9rem;
            padding: 0.9rem;
            height: 100%;
        }

        .input-shell .form-label {
            margin-bottom: 0.45rem;
        }

        .input-shell .input-helper,
        .input-shell .error-message {
            margin-bottom: 0;
        }

        @media (max-width: 767.98px) {
            .form-body {
                padding: 1.5rem;
            }

            .search-row,
            .coords-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <a href="{{ route('home') }}" class="btn-back">← Back to home</a>

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="form-container">
                    <div class="form-header">
                        <h1 class="h3 mb-2">Location Assessment</h1>
                        <p class="mb-0">Enter coordinates and site details to get greening estimates and AI recommendations.</p>
                    </div>

                    <div class="form-body">
                        <div class="info-box">
                            <p class="info-box-title">What we'll analyze:</p>
                            <p class="info-box-text">• Local air quality (AQI)<br>
                            • Tree gap percentage<br>
                            • Carbon capture potential<br>
                            • AI-powered greening recommendations</p>
                        </div>

                        <form action="{{ route('assess.location.store') }}" method="POST">
                            @csrf

                            <div class="field-section">
                                <p class="section-label">Find location</p>
                                <p class="section-copy">Search by address or place name to populate the core location fields automatically.</p>
                                <div class="search-panel">
                                    <label for="address_search" class="form-label">Search by address, city, or place name</label>
                                    <div class="search-row">
                                        <input
                                            type="text"
                                            id="address_search"
                                            class="form-control form-input"
                                            placeholder="e.g., DHA Phase 6 Karachi, Lahore Cantt, Gulberg Lahore"
                                            value="{{ old('location_name') ?: old('city') }}"
                                        >
                                        <button type="button" class="btn-search" id="search_location_button">
                                            <i class="bi bi-search me-1"></i>
                                            Search
                                        </button>
                                    </div>
                                    <p class="search-status mb-0" id="search_status">Search for an address to autofill latitude, longitude, city, and area.</p>
                                    <div class="result-list" id="search_results" hidden></div>
                                </div>
                            </div>

                            <div class="field-section">
                                <p class="section-label">Location details</p>
                                <p class="section-copy">Provide the place details that should appear in the final assessment record.</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-shell">
                                            <label for="location_name" class="form-label">Area / locality</label>
                                            <input
                                                type="text"
                                                id="location_name"
                                                name="location_name"
                                                class="form-control form-input @error('location_name') is-invalid @enderror"
                                                placeholder="e.g., Gulshan-e-Iqbal Block 7"
                                                value="{{ old('location_name') }}"
                                            >
                                            <p class="input-helper">Neighbourhood, sector, park, or local area name</p>
                                            @error('location_name')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-shell">
                                            <label for="city" class="form-label">City</label>
                                            <input
                                                type="text"
                                                id="city"
                                                name="city"
                                                class="form-control form-input @error('city') is-invalid @enderror"
                                                placeholder="e.g., Karachi"
                                                value="{{ old('city') }}"
                                            >
                                            <p class="input-helper">Used to label the assessment clearly</p>
                                            @error('city')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field-section">
                                <p class="section-label">Coverage settings</p>
                                <p class="section-copy">Define the wider coverage area and the radius to analyze around the selected point.</p>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="input-shell">
                                            <label for="country" class="form-label">Country</label>
                                            <input
                                                type="text"
                                                id="country"
                                                name="country"
                                                class="form-control form-input @error('country') is-invalid @enderror"
                                                placeholder="e.g., Pakistan"
                                                value="{{ old('country') }}"
                                            >
                                            <p class="input-helper">Country or region for this selected place</p>
                                            @error('country')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-shell">
                                            <label for="radius_km" class="form-label">Coverage radius (kilometers)</label>
                                            <input
                                                type="number"
                                                id="radius_km"
                                                name="radius_km"
                                                class="form-control form-input @error('radius_km') is-invalid @enderror"
                                                placeholder="e.g., 2.5"
                                                min="0.1"
                                                max="25"
                                                step="0.1"
                                                value="{{ old('radius_km', old('radius_m') ? number_format(old('radius_m') / 1000, 1, '.', '') : '0.5') }}"
                                                required
                                            >
                                            <p class="input-helper">How many kilometers around the center point should be included</p>
                                            @error('radius_km')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field-section">
                                <p class="section-label">Coordinates</p>
                                <p class="section-copy">These coordinates are filled from search results, but you can edit them manually if needed.</p>
                                <div class="coords-grid">
                                    <div>
                                        <div class="input-shell">
                                            <label for="latitude" class="form-label">Latitude</label>
                                            <input
                                                type="number"
                                                id="latitude"
                                                name="latitude"
                                                class="form-control form-input @error('latitude') is-invalid @enderror"
                                                placeholder="e.g., 24.8607"
                                                step="0.000001"
                                                min="-90"
                                                max="90"
                                                required
                                                value="{{ old('latitude') }}"
                                            >
                                            <p class="input-helper">North or south coordinate for the selected location</p>
                                            @error('latitude')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <div class="input-shell">
                                            <label for="longitude" class="form-label">Longitude</label>
                                            <input
                                                type="number"
                                                id="longitude"
                                                name="longitude"
                                                class="form-control form-input @error('longitude') is-invalid @enderror"
                                                placeholder="e.g., 67.0011"
                                                step="0.000001"
                                                min="-180"
                                                max="180"
                                                required
                                                value="{{ old('longitude') }}"
                                            >
                                            <p class="input-helper">East or west coordinate for the selected location</p>
                                            @error('longitude')
                                                <p class="error-message">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="field-section">
                                <p class="section-label">Site profile</p>
                                <p class="section-copy">Urban density is automatically derived from Google location data after you choose a search result.</p>
                                <div class="input-shell">
                                    <label for="urban_density_display" class="form-label">Urban density</label>
                                    <input
                                        type="text"
                                        id="urban_density_display"
                                        class="form-control form-input"
                                        value="{{ old('urban_density') === 'high' ? 'High density urban area' : (old('urban_density') === 'low' ? 'Low density suburban or rural area' : 'Medium density mixed-use area') }}"
                                        readonly
                                    >
                                    <input
                                        type="hidden"
                                        id="urban_density"
                                        name="urban_density"
                                        value="{{ old('urban_density', 'medium') }}"
                                    >
                                    <p class="input-helper">This field is not editable. It updates automatically when you select a Google location result.</p>
                                    @error('urban_density')
                                        <p class="error-message">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-submit btn-success">
                                    Generate Assessment
                                </button>
                            </div>
                        </form>

                        <hr style="margin-top: 2rem; margin-bottom: 1.5rem; border-color: rgba(15, 23, 42, 0.08);">

                        <div style="font-size: 0.875rem; color: #64748b; text-align: center;">
                            <p class="mb-1"><strong>Example search:</strong></p>
                            <p class="mb-0">Try "Clifton Block 5 Karachi" or "Gulberg III Lahore"</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const searchInput = document.getElementById('address_search');
        const searchButton = document.getElementById('search_location_button');
        const searchStatus = document.getElementById('search_status');
        const searchResults = document.getElementById('search_results');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const locationNameInput = document.getElementById('location_name');
        const cityInput = document.getElementById('city');
        const countryInput = document.getElementById('country');
        const densityInput = document.getElementById('urban_density');
        const densityDisplay = document.getElementById('urban_density_display');
        let searchDebounceTimer = null;
        let googleGeocoder = null;

        function densityLabel(value) {
            return {
                high: 'High density urban area',
                medium: 'Medium density mixed-use area',
                low: 'Low density suburban or rural area'
            }[value] || 'Calculated from Google location data';
        }

        function setStatus(message, isError = false) {
            searchStatus.textContent = message;
            searchStatus.style.color = isError ? '#dc2626' : '#64748b';
        }

        function inferUrbanDensity(types = []) {
            if (types.some((type) => ['street_address', 'premise', 'subpremise', 'intersection', 'route'].includes(type))) {
                return 'high';
            }

            if (types.some((type) => ['neighborhood', 'sublocality', 'sublocality_level_1', 'locality', 'postal_town'].includes(type))) {
                return 'medium';
            }

            return 'low';
        }

        function componentValue(components, supportedTypes) {
            const component = components.find((entry) =>
                (entry.types || []).some((type) => supportedTypes.includes(type))
            );

            return component ? component.long_name : '';
        }

        function renderResults(results) {
            searchResults.innerHTML = '';

            if (!results.length) {
                searchResults.hidden = true;
                setStatus('No matching locations found. Try a more specific address or city name.', true);
                return;
            }

            results.forEach((result) => {
                const item = document.createElement('button');
                item.type = 'button';
                item.className = 'result-item';

                const area = result.location_name || result.display_name.split(',')[0];
                const city = result.city || '';
                const country = result.country || '';

                item.innerHTML = `
                    <div class="result-title">${result.display_name}</div>
                    <p class="result-meta">Area: ${area || 'N/A'} | City: ${city || 'N/A'} | Density: ${densityLabel(result.urban_density)} | Lat: ${Number(result.latitude).toFixed(6)} | Lng: ${Number(result.longitude).toFixed(6)}</p>
                `;

                item.addEventListener('click', () => {
                    latitudeInput.value = Number(result.latitude).toFixed(6);
                    longitudeInput.value = Number(result.longitude).toFixed(6);
                    locationNameInput.value = area || locationNameInput.value;
                    cityInput.value = city || cityInput.value;
                    countryInput.value = country || countryInput.value;
                    densityInput.value = result.urban_density || 'medium';
                    densityDisplay.value = densityLabel(result.urban_density);
                    searchInput.value = result.display_name;
                    searchResults.hidden = true;
                    setStatus('Location selected. Latitude, longitude, city, area, and urban density were filled in from Google data.');
                });

                searchResults.appendChild(item);
            });

            searchResults.hidden = false;
            setStatus('Select the best matching location below.');
        }

        async function searchLocation() {
            const query = searchInput.value.trim();

            if (!query) {
                setStatus('Enter an address, city, or area before searching.', true);
                searchResults.hidden = true;
                return;
            }

            if (query.length < 3) {
                setStatus('Keep typing to search for a more specific location.');
                searchResults.hidden = true;
                return;
            }

            searchButton.disabled = true;
            setStatus('Searching location...');
            searchResults.hidden = true;

            try {
                if (!googleGeocoder || !window.google || !window.google.maps) {
                    throw new Error('Google Maps is not ready.');
                }

                googleGeocoder.geocode({ address: query }, (results, status) => {
                    searchButton.disabled = false;

                    if (status !== 'OK' || !Array.isArray(results)) {
                        searchResults.hidden = true;
                        setStatus('Google could not find this location. Try a more specific address or area name.', true);
                        return;
                    }

                    const mappedResults = results.slice(0, 5).map((result) => {
                        const components = result.address_components || [];
                        const location = result.geometry?.location;

                        return {
                            display_name: result.formatted_address,
                            location_name: componentValue(components, ['sublocality', 'sublocality_level_1', 'neighborhood', 'route', 'premise']) || componentValue(components, ['locality']) || result.formatted_address.split(',')[0],
                            city: componentValue(components, ['locality', 'postal_town', 'administrative_area_level_2']) || componentValue(components, ['administrative_area_level_1']),
                            country: componentValue(components, ['country']),
                            latitude: location ? location.lat() : null,
                            longitude: location ? location.lng() : null,
                            urban_density: inferUrbanDensity(result.types || []),
                        };
                    });

                    renderResults(mappedResults);
                });
            } catch (error) {
                searchResults.hidden = true;
                searchButton.disabled = false;
                setStatus('Google location search is unavailable right now. You can still enter latitude and longitude manually.', true);
            }
        }

        window.initGoogleLocationSearch = function initGoogleLocationSearch() {
            if (window.google && window.google.maps) {
                googleGeocoder = new window.google.maps.Geocoder();
                setStatus('Type a location name like Lahore, Clifton Karachi, or Gulberg Lahore to see live results.');
            }
        };

        searchButton.addEventListener('click', searchLocation);
        searchInput.addEventListener('input', () => {
            clearTimeout(searchDebounceTimer);

            if (!searchInput.value.trim()) {
                searchResults.hidden = true;
                setStatus('Search for an address to autofill latitude, longitude, city, and area.');
                return;
            }

            searchDebounceTimer = setTimeout(() => {
                searchLocation();
            }, 450);
        });

        searchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchLocation();
            }
        });
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ urlencode(config('services.google.maps_key')) }}&callback=initGoogleLocationSearch"></script>
</body>
</html>
