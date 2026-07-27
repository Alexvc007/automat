@extends('layouts.app')
@section('title', 'Directorio de talleres')
@section('header', 'Administrar directorio de talleres')

@section('content')
<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2 bg-white rounded-xl border shadow-sm overflow-x-auto">
        <div class="px-5 py-3 border-b">
            <form method="GET" class="flex gap-2 flex-wrap">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar taller..." class="border rounded-lg px-3 py-2 text-sm w-56">
                <button class="bg-slate-900 text-white px-4 py-2 rounded-lg text-sm">Buscar</button>
            </form>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-5 py-3">Nombre</th>
                    <th class="text-left px-5 py-3">Dirección</th>
                    <th class="text-left px-5 py-3">Teléfono</th>
                    <th class="text-right px-5 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($talleres as $t)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-medium">{{ $t->nombre }}</td>
                    <td class="px-5 py-3">{{ $t->direccion }}</td>
                    <td class="px-5 py-3">{{ $t->telefono ?? '—' }}</td>
                    <td class="px-5 py-3 text-right space-x-2">
                        <a href="{{ route('talleres.edit', $t) }}" class="text-blue-600 hover:underline">Editar</a>
                        <form method="POST" action="{{ route('talleres.destroy', $t) }}" class="inline" onsubmit="return confirm('¿Eliminar este taller del directorio?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-6 text-center text-gray-400">Aún no hay talleres registrados en el directorio.</td></tr>
                @endforelse
            </tbody>
        </table>
        <x-pagination :paginator="$talleres" />
    </div>

    <div class="bg-white rounded-xl border shadow-sm p-5 h-fit">
        <h3 class="font-semibold text-gray-800 mb-3">Registrar nuevo taller</h3>
        <p class="text-xs text-gray-500 mb-3">Haz clic en el mapa para marcar la ubicación exacta; la latitud y longitud se llenan solas.</p>
        <form method="POST" action="{{ route('talleres.store') }}" class="space-y-3">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre del taller" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="direccion" placeholder="Dirección" required class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="ciudad" placeholder="Ciudad" value="Santa Cruz de la Sierra" class="w-full border rounded-lg px-3 py-2 text-sm">
            <input type="text" name="telefono" placeholder="Teléfono (opcional)" class="w-full border rounded-lg px-3 py-2 text-sm">

            <div id="mapaSelector" class="rounded-lg border w-full h-[220px]"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input type="text" name="latitud" id="latitud" placeholder="Latitud" required readonly class="border rounded-lg px-3 py-2 text-sm bg-gray-50">
                <input type="text" name="longitud" id="longitud" placeholder="Longitud" required readonly class="border rounded-lg px-3 py-2 text-sm bg-gray-50">
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">Guardar taller</button>
        </form>
    </div>
</div>

<script>
(g => {var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
({key: "{{ env('GOOGLE_MAPS_API_KEY') }}", v: "weekly"});

async function iniciarMapaSelector() {
    const { Map } = await google.maps.importLibrary("maps");
    const centro = { lat: -17.7833, lng: -63.1821 };
    const mapa = new Map(document.getElementById('mapaSelector'), { center: centro, zoom: 12, mapId: 'AUTOMASTER_MAPA_SELECTOR' });
    let marcador;

    mapa.addListener('click', (e) => {
        const lat = e.latLng.lat();
        const lng = e.latLng.lng();
        document.getElementById('latitud').value = lat.toFixed(7);
        document.getElementById('longitud').value = lng.toFixed(7);

        if (marcador) {
            marcador.setPosition(e.latLng);
        } else {
            marcador = new google.maps.Marker({ position: e.latLng, map: mapa });
        }
    });
}
iniciarMapaSelector();
</script>
@endsection
