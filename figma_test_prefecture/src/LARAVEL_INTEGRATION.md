# Laravel統合ガイド

## 実装内容

都道府県別のサーフスポット一覧ページをLaravel Bladeテンプレートとして実装しました。

## ファイル構成

### 1. Bladeテンプレート
- **resources/views/surf/prefecture.blade.php**
  - 都道府県一覧ページのメインテンプレート
  - `<x-app-layout>` コンポーネントを使用

### 2. コントローラー
- **app/Http/Controllers/SurfController.php**
  - `prefecture()` メソッドを追加
  - エリア、ロケーション、都道府県の説明文データを管理

### 3. ルート
- **routes/web.php**
  - `/surf/prefecture` - 都道府県一覧ページ
  - `/surf/spot/{id}` - スポット詳細ページ（後で実装）

## データ構造

### Areas（エリア）
```php
[
    'id' => 1,
    'name' => '湘南',
    'prefecture_name' => '神奈川県',
    'region_name' => '関東'
]
```

### Locations（ロケーション/サーフスポット）
```php
[
    'id' => 1,
    'area_id' => 1,
    'name' => '鎌倉',
    'shoreline_direction' => 'S'
]
```

## 使用方法

### 1. アクセス
```
http://your-domain.com/surf/prefecture
```

### 2. 都道府県を選択
- サイドバーのドロップダウンから都道府県を選択
- 選択した都道府県のエリアとサーフスポットが表示されます

### 3. スポットの詳細を見る
- 各スポットカードをクリックすると詳細ページに遷移します
- 現在は `/surf/spot/{id}` にリダイレクトされます（実装が必要）

## データベースへの移行

現在はコントローラー内にモックデータとして実装していますが、本番環境では以下のテーブルを作成してデータベースに移行することをお勧めします。

### 1. テーブル作成（マイグレーション例）

#### areasテーブル
```php
Schema::create('areas', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('prefecture_name');
    $table->string('region_name');
    $table->timestamps();
});
```

#### locationsテーブル
```php
Schema::create('locations', function (Blueprint $table) {
    $table->id();
    $table->foreignId('area_id')->constrained()->onDelete('cascade');
    $table->string('name');
    $table->string('shoreline_direction', 3);
    $table->timestamps();
});
```

#### scoresテーブル（波情報データ）
```php
Schema::create('scores', function (Blueprint $table) {
    $table->id();
    $table->foreignId('location_id')->constrained()->onDelete('cascade');
    $table->date('date');
    $table->time('time');
    $table->decimal('wave_height', 3, 1);
    $table->string('wave_direction', 3);
    $table->decimal('wind_speed', 3, 1);
    $table->string('wind_direction', 3);
    $table->string('weather')->nullable();
    $table->integer('temperature')->nullable();
    $table->timestamps();
    
    $table->unique(['location_id', 'date', 'time']);
});
```

### 2. モデルの作成

```bash
php artisan make:model Area
php artisan make:model Location
php artisan make:model Score
```

### 3. コントローラーの更新

データベースからデータを取得するように変更：

```php
public function prefecture(Request $request)
{
    $selectedPrefecture = $request->input('prefecture', '神奈川県');
    
    // データベースから取得
    $areasInPrefecture = Area::where('prefecture_name', $selectedPrefecture)
        ->with('locations')
        ->get();
    
    // ...
}
```

## カスタマイズ

### 都道府県の説明文を変更
`SurfController.php` の `getPrefectureDescription()` メソッド内で説明文を編集できます。

### スポットカードのデザイン変更
`resources/views/surf/prefecture.blade.php` のスポットカード部分を編集してください。

### 海岸の向きインジケーター
Bladeテンプレート内の `createDirectionIndicator()` 関数でカスタマイズできます。

## 次のステップ

1. **スポット詳細ページの実装**
   - 既存の `/surf` (dashboard) ページをベースに作成
   - ルートパラメータからスポットIDを受け取る

2. **データベース移行**
   - マイグレーションファイルを作成
   - シーダーでサンプルデータを投入
   - コントローラーをEloquent対応に変更

3. **認証の追加**
   - 必要に応じて `auth` ミドルウェアを追加
   - ログインユーザーのみアクセス可能にする

4. **API連携**
   - 外部APIから実際の波情報を取得
   - 定期的にデータを更新するバッチ処理を追加

## トラブルシューティング

### `<x-app-layout>` が見つからない
- Laravelのレイアウトコンポーネントが必要です
- `resources/views/layouts/app.blade.php` を作成してください

### スタイルが適用されない
- Tailwind CSSが設定されているか確認
- `npm run dev` または `npm run build` を実行

### ルートが見つからない
```bash
php artisan route:list
```
でルートが登録されているか確認してください。

## サポート

質問や問題がある場合は、プロジェクトの開発チームにお問い合わせください。
