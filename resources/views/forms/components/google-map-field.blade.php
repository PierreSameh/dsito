<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    :id="$getId()"
    :label="$getLabel()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
    <div
        wire:ignore
        x-data="googleMapField({
            apiKey: '{{ $getExtraAttributes()['data-api-key'] }}',
            mapId: '{{ $getId() }}_map',
            lat: '{{ $getStatePath() }}_latitude',
            lng: '{{ $getStatePath() }}_longitude'
        })"
        x-init="init"
    >
        <div id="{{ $getId() }}_map" style="height: 400px; width: 100%; border: 1px solid red;"></div>
        <input type="hidden" x-model="lat" :name="lat">
        <input type="hidden" x-model="lng" :name="lng">
    </div>
</x-dynamic-component>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('googleMapField', ({ apiKey, mapId, lat, lng }) => ({
        lat: null,
        lng: null,
        map: null,
        marker: null,
        init() {
            this.loadGoogleMapsScript();
        },
        loadGoogleMapsScript() {
            if (typeof google === 'undefined') {
                const script = document.createElement('script');
                script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initGoogleMap`;
                script.async = true;
                script.defer = true;
                document.head.appendChild(script);
                window.initGoogleMap = this.initMap.bind(this);
            } else {
                this.initMap();
            }
        },
        initMap() {
            console.log('Initializing map');
            const mapElement = document.getElementById(mapId);
            if (mapElement) {
                console.log('Map element found:', mapElement);
                this.map = new google.maps.Map(mapElement, {
                    center: { lat: 24.774265, lng: 46.738586 },
                    zoom: 8
                });
                this.map.addListener('click', (event) => {
                    this.placeMarker(event.latLng);
                    this.lat = event.latLng.lat();
                    this.lng = event.latLng.lng();
                    
                    // Livewire.emit('updateCoordinates', { lat: this.lat, lng: this.lng });

                });

                const newPosition = { lat: parseFloat(document.getElementById('data.lat').value), lng: parseFloat(document.getElementById('data.lng').value) };

                // Create the marker and place it on the map immediately
                this.marker = new google.maps.Marker({
                    position: newPosition,
                    map: this.map // Attach the marker to the map directly
                });

                // Center the map on the new marker position
                this.map.setCenter(newPosition);
            } else {
                console.error('Map element not found:', mapId);
            }
        },
        placeMarker(location) {
            console.log('Placing marker at:', location.lat(), location.lng());
            let lngItem = document.getElementById("data.lng");
            lngItem.value = location.lng();

            let latItem = document.getElementById("data.lat");
            latItem.value = location.lat();

            // Dispatch input and change events
            let inputEvent = new Event('input', { bubbles: true });
            let changeEvent = new Event('change', { bubbles: true });

            lngItem.dispatchEvent(inputEvent);
            lngItem.dispatchEvent(changeEvent);

            latItem.dispatchEvent(inputEvent);
            latItem.dispatchEvent(changeEvent);

            

            this.$wire.set('data.lng', lngItem.value); // Notify Livewire of the new value
            this.$wire.set('data.lat', latItem.value); // Notify Livewire of the new value
            // Livewire.emit('refresh');

            // document.getElementById('data.lat').value = location.lat();
            if (this.marker) {
                this.marker.setPosition(location);
            } else {
                this.marker = new google.maps.Marker({
                    position: location,
                    map: this.map
                });
            }
            this.lat = location.lat();
            this.lng = location.lng();

            
            // Emit a custom event with the new coordinates
            this.$dispatch('coordinates-updated', { lat: latItem.value, lng: lngItem.value });
        }
    }));
});
</script>
@endpush