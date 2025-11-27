# サーフィン波情報ダッシュボード - Laravel PHP版

このプロジェクトは、サーフィンスポットの波高、風速、風向などの情報を表示するWebアプリケーションです。
Laravel + Blade + バニラJavaScript + Chart.jsで構築されています。

## 必要要件

- PHP >= 8.1
- Composer
- Node.js >= 16 (フロントエンドアセットのビルド用)
- npm または yarn

## セットアップ手順

### 1. リポジトリのクローン
```bash
git clone <repository-url>
cd surf-dashboard
```

### 2. PHP依存関係のインストール
```bash
composer install
```

### 3. 環境設定
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Node.js依存関係のインストール（CSSビルド用）
```bash
npm install
# または
yarn install
```

### 5. フロントエンドアセットのビルド
```bash
npm run build
# または開発中は
npm run dev
```

### 6. データベース設定（オプション）
現在はモックデータを使用しているため、データベースは必須ではありませんが、
将来的にデータを永続化する場合は以下を実行してください。

```bash
php artisan migrate
```

### 7. 開発サーバーの起動
```bash
php artisan serve
```

## 使用方法

1. ブラウザで `http://localhost:8000/surf` にアクセス
2. サーフスポットを選択
3. 日付を選択
4. 波情報とチャートを確認

## 使用技術

### バックエンド
- Laravel 10.x
- PHP 8.1+

### フロントエンド
- Blade Templates
- Vanilla JavaScript
- Chart.js (チャート表示)
- Tailwind CSS (スタイリング)

### 外部ライブラリ
- Chart.js: データ可視化
- Tailwind CSS: UIスタイリング

## 主な機能

- サーフスポット選択（湘南、九十九里浜、静波海岸、磯ノ浦）
- 日付選択（前日・翌日ボタン付き）
- 1時間ごとの波高・風速データ表示
- インタラクティブなチャート表示（波高・風速切り替え）
- 海岸向きに基づくコンディション評価
- オンショア/オフショア/サイドショア判定
- 今日のハイライト（最高波高時間、最も風が弱い時間）
- レスポンシブデザイン

## APIエンドポイント

- `GET /api/surf/wave-data` - 波情報データ取得
- `GET /api/surf/spots` - サーフスポット一覧取得

## カスタマイズ

### 実際の気象APIとの連携
実際の気象データを使用する場合は、`SurfController`の`generateMockData`メソッドを外部APIの呼び出しに置き換えてください。

推奨API:
- OpenWeatherMap API
- 気象庁API
- MSW（マリンスポーツウェーブ）API

### 新しいサーフスポットの追加
`SurfController`の`$surfSpots`配列に新しいスポット情報を追加してください。

```php
[
    'id' => 'new_spot',
    'name' => '新しいスポット名',
    'location' => '都道府県',
    'coast_direction' => 'E' // N, NE, E, SE, S, SW, W, NW
]
```

## ファイル構成

```
├── app/Http/Controllers/SurfController.php  # メインコントローラー
├── resources/views/surf/dashboard.blade.php # メインテンプレート
├── routes/web.php                           # ルート定義
├── public/css/surf.css                      # 追加CSS
└── README.md                                # このファイル
```

## トラブルシューティング

### Chart.jsが表示されない
CDNからの読み込みに失敗している可能性があります。ローカルにChart.jsをインストールして使用してください。

```bash
npm install chart.js
```

### スタイルが適用されない
Tailwind CSSのビルドが完了していない可能性があります。

```bash
npm run build
```

### APIエラーが発生する
Laravelのログを確認してください。

```bash
php artisan log:clear
tail -f storage/logs/laravel.log
```

## ライセンス

MIT License

## 貢献

プルリクエストやイシューの報告を歓迎します。