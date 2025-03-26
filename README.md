# Konvence pojmenování
- **Jazyk:** angličtina

### Složky
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
- **Cizí klíče:** `[singular_table_name]_id` (např. `user_id`, `product_category_id`)
- **Kompozitní klíče:** kombinace sloupců s jasným významem

## Kód

### Routy (URL)
- **Notace:** snake_case
- **Příklady:**
  ```php
  Route::get('/user_profile', ...);
  Route::post('/save_product', ...);
  Route::get('/product_categories/{id}', ...);
  ```

### Views
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
  class UserController {}
  class ProductCategory {}
  ```

#### Modely
- **Prefix:** `M_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class M_User extends Model {}
  class M_ProductCategory extends Model {}
  ```

#### Controllery
- **Prefix:** `C_`
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class C_UserController extends Controller {}
  class C_ProductController extends Controller {}
  ```

#### Knihovny
- **Notace:** PascalCase
- **Příklady:**
  ```php
  class StringHelper {}
  class PdfGenerator {}
  ```
