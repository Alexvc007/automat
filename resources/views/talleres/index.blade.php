@extends('layouts.app')
@section('title', 'Buscar talleres')
@section('header', 'Buscar talleres en la ciudad')

@section('content')
<div class="bg-white rounded-xl border shadow-sm p-5 mb-4">
    <div class="flex gap-2">
        <input type="text" id="buscarNombre" placeholder="Escribe el nombre del taller que buscas..."
               class="flex-1 border rounded-lg px-3 py-2 text-sm" onkeydown="if(event.key==='Enter') buscarTaller()">
        <button onclick="buscarTaller()" class="bg-slate-900 text-white px-5 py-2 rounded-lg text-sm">Buscar</button>
    </div>
    <p id="estadoBusqueda" class="text-xs text-gray-500 mt-2"></p>
</div>

<div class="bg-white rounded-xl border shadow-sm overflow-x-auto">
    <div id="mapa" class="w-full h-[320px] sm:h-[420px] md:h-[520px]"></div>
</div>

@if(auth()->user()->isAdmin())
<p class="text-sm text-gray-500 mt-3">
    ¿El taller que buscas no aparece? <a href="{{ route('talleres.administrar') }}" class="text-blue-600 hover:underline">Regístralo en el directorio</a>.
</p>
@endif

<script>
(g => {var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "{{ env('GOOGLE_MAPS_API_KEY') }}", v: "weekly"});

let mapa;
let marcadores = [];
const centroSantaCruz = { lat: -17.7833, lng: -63.1821 };

async function iniciarMapa() {
    const { Map } = await google.maps.importLibrary("maps");
    mapa = new Map(document.getElementById('mapa'), {
        center: centroSantaCruz,
        zoom: 13,
        mapId: 'AUTOMASTER_MAPA_TALLERES',
    });
}
iniciarMapa();

// --- MOVIDO DENTRO DEL SCRIPT ---
function limpiarMarcadores() {
    marcadores.forEach(m => m.setMap(null));
    marcadores = [];
}

async function buscarTaller() {
    const nombre = document.getElementById('buscarNombre').value.trim();
    const estado = document.getElementById('estadoBusqueda');
    estado.textContent = 'Buscando...';

    try {
        const response = await fetch(`{{ route('talleres.buscar') }}?nombre=${encodeURIComponent(nombre)}`);
        const talleres = await response.json();

        limpiarMarcadores();

        if (talleres.length === 0) {
            estado.textContent = 'No se encontró ningún taller registrado con ese nombre.';
            return;
        }

        const limites = new google.maps.LatLngBounds();

        talleres.forEach(t => {
            const posicion = { lat: parseFloat(t.latitud), lng: parseFloat(t.longitud) };
            const marcador = new google.maps.Marker({
                position: posicion,
                map: mapa,
                title: t.nombre,
                icon: {
                    path: google.maps.SymbolPath.CIRCLE,
                    scale: 9,
                    fillColor: '#dc2626',
                    fillOpacity: 1,
                    strokeColor: '#7f1d1d',
                    strokeWeight: 2,
                },
            });

            const ventanaInfo = new google.maps.InfoWindow({
                content: `<div style="font-size:13px"><strong>${t.nombre}</strong><br>${t.direccion}${t.telefono ? '<br>Tel: ' + t.telefono : ''}</div>`,
            });
            marcador.addListener('click', () => ventanaInfo.open(mapa, marcador));

            marcadores.push(marcador);
            limites.extend(posicion);
        });

        mapa.fitBounds(limites);
        if (talleres.length === 1) mapa.setZoom(15);
        estado.textContent = `${talleres.length} taller(es) encontrado(s).`;
    } catch (e) {
        estado.textContent = 'Ocurrió un error al buscar. Intenta de nuevo.';
    }
}
</script> {{-- El script debe cerrar AQUÍ --}}
@endsection