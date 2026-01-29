@extends('layouts.custom')

@section('content')
@php
    $defaultPrefectureId = $defaultPrefecture?->id;
    $kanagawaId = $allPrefectures
        ->first(fn ($pref) => str_contains($pref->name, '神奈川県'))
        ?->id;
    $selectedPrefectureId = $defaultPrefectureId ?? $kanagawaId;
@endphp
<style>
    #search-button {
        background-color: #0b5cad;
        color: #ffffff;
        border-color: #0b5cad;
    }
    #search-button:hover {
        background-color: #094b8f;
        border-color: #094b8f;
    }
</style>
<main class="min-h-screen bg-gradient-to-b from-sky-100 via-white to-white pt-24 pb-16 font-sans text-slate-900" style="background: linear-gradient(180deg, #eaf4ff 0%, #ffffff 40%);">
    <div class="mx-auto flex max-w-4xl flex-col gap-3 px-4 sm:px-6 lg:px-8">
        <section class="bg-white text-gray-900 rounded-lg border shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h2 class="font-semibold leading-none tracking-tight">Surf Forecastとは</h2>
            </div>
            <div class="p-6 pt-0">
                <p class="text-sm text-gray-600 leading-relaxed">
                    Surf Forecastは神奈川県を中心に日本の各地のサーフスポット情報や波情報・波予報を提供するwebサイトです。
                    向こう14日間の波高・風速等の気象データをサーフスポットごとに毎日更新中。過去分のデータも参照することができます。
                </p>
            </div>
        </section>   
        <section>
            <div class="bg-white text-gray-900 rounded-lg border shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h2 class="font-semibold leading-none tracking-tight">サーフスポットの波情報・波予報を確認する</h2>
                </div>
                <div class="p-6 pt-0">
                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 lg:items-end">
                        <div class="space-y-2">
                            <label for="prefecture-select" class="text-sm font-medium">都道府県</label>
                            <select id="prefecture-select" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            @foreach($allPrefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" {{ $prefecture->id === $selectedPrefectureId ? 'selected' : '' }}>
                                    {{ $prefecture->name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                        <div class="space-y-2">
                            <label for="location-select" class="text-sm font-medium">スポット</label>
                            <select id="location-select" class="flex h-10 w-full rounded-md border border-input bg-input-background px-3 py-2 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2">
                            @forelse($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @empty
                                <option value="">スポットがありません</option>
                            @endforelse
                        </select>
                        </div>
                        <button class="inline-flex h-10 w-full items-center justify-center whitespace-nowrap rounded-md border border-gray-300 bg-white hover:bg-gray-50 px-3 text-sm font-medium" id="search-button" type="button">検索</button>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-white text-gray-900 rounded-lg border shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <h2 class="font-semibold leading-none tracking-tight">サーフスポットを都道府県から探す</h2>
            </div>
            <div class="p-6 pt-0">
                <div class="grid gap-4 sm:grid-cols-2">
                    <a class="flex items-center justify-between rounded-md border border-gray-300 bg-white hover:bg-gray-50 h-10 px-3 text-sm font-medium" href="/prefectures?prefecture_id={{ $selectedPrefectureId }}">神奈川県</a>
                    <div class="flex items-center justify-between rounded-md border border-dashed border-gray-300 bg-white h-10 px-3 text-sm font-medium text-gray-400">千葉県（準備中）</div>
                </div>
            </div>
        </section>
    </div>
</main>

<script>
    const prefectureSelect = document.getElementById('prefecture-select');
    const locationSelect = document.getElementById('location-select');
    const searchButton = document.getElementById('search-button');

    const renderLocations = (locations) => {
        locationSelect.innerHTML = '';
        if (!locations.length) {
            const option = document.createElement('option');
            option.value = '';
            option.textContent = 'スポットがありません';
            locationSelect.appendChild(option);
            return;
        }
        locations.forEach((location) => {
            const option = document.createElement('option');
            option.value = location.id;
            option.textContent = location.name;
            locationSelect.appendChild(option);
        });
    };

    prefectureSelect.addEventListener('change', async () => {
        const prefectureId = prefectureSelect.value;
        if (!prefectureId) {
            renderLocations([]);
            return;
        }
        const response = await fetch(`/api/locations-by-prefecture?prefecture_id=${encodeURIComponent(prefectureId)}`);
        if (!response.ok) {
            renderLocations([]);
            return;
        }
        const locations = await response.json();
        renderLocations(locations);
    });

    searchButton.addEventListener('click', () => {
        const locationId = locationSelect.value;
        if (!locationId) {
            return;
        }
        window.location.href = `/locations/${locationId}`;
    });
</script>
@endsection