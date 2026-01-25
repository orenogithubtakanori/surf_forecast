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
    .top-page {
        padding: 140px 20px 80px;
        background: linear-gradient(180deg, #eaf4ff 0%, #ffffff 40%);
        min-height: 100vh;
        font-family: 'Hiragino Sans', 'Hiragino Kaku Gothic ProN', 'Hiragino Kaku Gothic Pro', 'Yu Gothic', 'Meiryo', sans-serif;
    }
    .top-container {
        max-width: 1040px;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        gap: 56px;
    }
    .hero-title {
        font-size: 24px;
        font-weight: 700;
        color: #0b2f4a;
        margin-bottom: 20px;
    }
    .search-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 16px 40px rgba(15, 60, 110, 0.12);
        display: grid;
        gap: 20px;
    }
    .search-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        align-items: end;
    }
    .field-group label {
        font-size: 13px;
        color: #4a6072;
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
    }
    .field-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #c8d7e6;
        border-radius: 10px;
        font-size: 14px;
        background: #f9fbff;
    }
    .primary-button {
        padding: 12px 20px;
        border-radius: 10px;
        border: none;
        background: #0b5cad;
        color: #ffffff;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s ease;
    }
    .primary-button:hover {
        background: #094b8f;
    }
    .section-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        box-shadow: 0 12px 30px rgba(15, 60, 110, 0.08);
    }
    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #0b2f4a;
        margin-bottom: 18px;
    }
    .prefecture-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }
    .prefecture-card {
        border: 1px solid #d4e0ec;
        border-radius: 14px;
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: #0b2f4a;
        background: #f7fbff;
        font-weight: 600;
    }
    .prefecture-card.is-disabled {
        background: #f4f4f4;
        color: #9aa6b2;
        border-style: dashed;
        cursor: default;
    }
    .about-text {
        font-size: 15px;
        line-height: 1.9;
        color: #3a4b5c;
    }
    @media (max-width: 640px) {
        .top-page {
            padding: 120px 16px 60px;
        }
        .search-card,
        .section-card {
            padding: 20px;
        }
    }
</style>

<main class="top-page">
    <div class="top-container">
        <section>
            <h2 class="hero-title">サーフスポットの波情報・波予報を確認する</h2>
            <div class="search-card">
                <div class="search-row">
                    <div class="field-group">
                        <label for="prefecture-select">都道府県</label>
                        <select id="prefecture-select">
                            @foreach($allPrefectures as $prefecture)
                                <option value="{{ $prefecture->id }}" {{ $prefecture->id === $selectedPrefectureId ? 'selected' : '' }}>
                                    {{ $prefecture->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field-group">
                        <label for="location-select">スポット</label>
                        <select id="location-select">
                            @forelse($locations as $location)
                                <option value="{{ $location->id }}">{{ $location->name }}</option>
                            @empty
                                <option value="">スポットがありません</option>
                            @endforelse
                        </select>
                    </div>
                    <button class="primary-button" id="search-button" type="button">検索</button>
                </div>
            </div>
        </section>

        <section class="section-card">
            <h2 class="section-title">サーフスポットを都道府県から探す</h2>
            <div class="prefecture-grid">
                <a class="prefecture-card" href="/prefectures?prefecture_id={{ $selectedPrefectureId }}">神奈川県</a>
                <div class="prefecture-card is-disabled">千葉県（準備中）</div>
            </div>
        </section>

        <section class="section-card">
            <h2 class="section-title">Surf Forecastとは</h2>
            <p class="about-text">
                Surf Forecastは神奈川県を中心に日本の各地のサーフスポット情報や波情報・波予報を提供するwebサイトです。
                向こう14日間の波高・風速等の気象データをサーフスポットごとに毎日更新中。過去分のデータも参照することができます。
            </p>
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