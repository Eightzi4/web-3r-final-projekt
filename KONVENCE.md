# Konvence pojmenování
- **Jazyk:** angličtina

## Složky
- **Notace:** kebab-case

## Databáze

### Tabulky
- **Číslo:** množné
- **Notace:** snake_case
- **Příklady:**
  - `users`
  - `product_categories`
  - `order_items`

### Sloupce
- **Číslo:** jednotné
- **Notace:** snake_case
- **Příklady:**
  - `first_name`
  - `created_at`
  - `is_active`

### Klíče
- **Primární klíč:** `id`
- **Cizí klíče:** jednotné číslo sloupce + _id postfix
- **Příklady:**
  - `user_id`
  - `product_category_id`
- **Kompozitní klíče:** kombinace sloupců
- **Příklady:**
  - `user_tags`
  - `user_images`

## Kód

### Proměnné
- **Notace:** snake_case
- **Příklady:**
  ```php
  $user_name = 'John';
  $total_price = 100.50;
  $is_valid = true;
  ```

### Třídy
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class Person {}
  class Item {}
  ```

#### Knihovny
- **Prefix:** `L_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class L_StringHelper {}
  class L_PdfGenerator {}
  ```

#### Controllery
- **Prefix:** `C_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class C_User extends Controller {}
  class C_Product extends Controller {}
  ```

#### Modely
- **Prefix:** `M_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class M_User extends Model {}
  class M_ProductCategory extends Model {}
  ```

#### Factories
- **Prefix:** `F_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class F_User extends Factory {}
  class F_ProductCategory extends Factory {}
  ```

#### Seedery
- **Prefix:** `S_`
- **Notace:** PascalCase
  ```php
  class S_User extends Seeder {}
  class S_ProductCategory extends Seeder {}
  ```

#### Views
- **Prefix:** `V_`
- **Notace:** PascalCase
- **Příklady:**
  ```
  resources/views/
    user-management/
      V_UserProfile.blade.php
      V_UserEdit.blade.php
    products/
      V_ProductList.blade.php
  ```
##### Částečné views
- **Prefix:** `_`
- **Notace:** snake_case
- **Příklady:**
  ```
  resources/views/
    partials/
      _game_card.blade.php
      _navbar.blade.php
  ```

#### Layouty
- **Prefix:** `V_`
- **Notace:** PascalCase
- **Příklady:**
  ```
  resources/views/
    layouts/
      V_App.blade.php
  ```

#### Routy (URL)
- **Notace:** snake_case
- **Příklady:**
  ```php
  Route::get('/user_profile', ...);
  Route::post('/save_product', ...);
  Route::get('/product_categories/{id}', ...);
  ```

#### Migrace
- **Notace:** snake_case
- **Příklady:**
  ```php
  0001_01_01_000000_create_jobs_table.php
  0001_01_01_000001_create_users_table.php
  ```
