# Dokumentace Aplikace GamePlatform

## Úvod

Tento dokument poskytuje přehled nejdůležitějších souborů tohoto projektu. Primárně se jedná o ty typy souborů, jejichž konvence jsou dokumentovány v souboru `KONVENCE.md`. Většinu souborů automaticky vytvořené Laravelem (například ty sloužící pro autentikaci uživatelů) v tomto dokumentu nenajdete.

---

## Kontrolery (`App\Http\Controllers`)

Následuje popis hlavních metod v jednotlivých kontrolerech aplikace. Popis se zaměřuje na obecnou funkcionalitu metody, nikoliv na detailní implementaci každého řádku kódu.

### 1. `App\Http\Controllers\Admin\C_Admin_UserController`

Správa uživatelů z administrátorského rozhraní.

*   **`index()`**:
    *   Zobrazí seznam všech uživatelů s paginací.
    *   Připravuje data pro "breadcrumbs" (drobečkovou navigaci).
*   **`edit(User $user)`**:
    *   Zobrazí formulář pro úpravu konkrétního uživatele.
    *   Načítá data uživatele do formuláře.
    *   Připravuje data pro "breadcrumbs".
*   **`update(Request $request, User $user)`**:
    *   Zpracovává data odeslaná z formuláře pro úpravu uživatele.
    *   Validuje vstupní data (jméno, email, administrátorská práva, status banu).
    *   Aktualizuje záznam uživatele v databázi.
    *   Přesměrovává zpět na seznam uživatelů s potvrzovací zprávou.
*   **`destroy(User $user)`**:
    *   Odstraní záznam konkrétního uživatele z databáze.
    *   Obsahuje logiku pro zabránění smazání vlastního účtu administrátora.
    *   Přesměrovává zpět na seznam uživatelů s potvrzovací zprávou.

### 2. `App\Http\Controllers\C_DeveloperPageController`

Zobrazení stránky detailu herního vývojáře.

*   **`show(M_Developers $developer)`**:
    *   Zobrazí veřejnou stránku s detailem konkrétního herního vývojáře.
    *   Načítá související data vývojáře (hry, obrázky, země původu) pomocí "eager loading".
    *   Zobrazuje hry od daného vývojáře s paginací.
    *   Připravuje data pro "breadcrumbs".

### 3. `App\Http\Controllers\C_Discover`

Zobrazení stránky pro objevování her.

*   **`index()`**:
    *   Zobrazí stránku s náhodným výběrem her pro "objevování".
    *   Načítá hry s jejich souvisejícími daty (vývojář, obrázky, nejnovější cena, tagy).
    *   Rozlišuje viditelnost her pro běžné uživatele a administrátory (admin vidí i skryté hry).
    *   Zobrazuje hry s paginací a v náhodném pořadí.
    *   Připravuje data pro "breadcrumbs".

### 4. `App\Http\Controllers\C_Game`

Správa a zobrazení detailů her.

*   **`__construct()`**:
    *   Konstruktor třídy, který aplikuje `admin` middleware na metody pro vytváření, úpravu a mazání her (`store`, `create`, `edit`, `update`, `destroy`, `adminIndex`, `destroyGameImage`). Metoda `show` je veřejná.
*   **`show(M_Games $game)`**:
    *   Zobrazí detailní stránku konkrétní hry.
    *   Kontroluje viditelnost hry (skryté hry jsou viditelné pouze pro administrátory).
    *   Načítá související data hry (vývojář, obrázky, tagy, ceny, recenze).
    *   Načítá a zobrazuje doporučené/podobné hry (např. hry od stejného vývojáře).
    *   Připravuje data pro "breadcrumbs".
*   **`create()`**:
    *   (Admin) Zobrazí formulář pro přidání nové hry.
    *   Poskytuje data pro výběrová pole (vývojáři, tagy, platformy, obchody).
    *   Připravuje data pro "breadcrumbs".
*   **`store(Request $request)`**:
    *   (Admin) Zpracovává data odeslaná z formuláře pro přidání nové hry.
    *   Validuje vstupní data (název, popis, vývojář, ceny, obrázky, tagy atd.).
    *   Ukládá novou hru a její související data (ceny, tagy, obrázky) do databáze v rámci databázové transakce.
    *   Přesměrovává na stránku úpravy nově vytvořené hry s potvrzovací zprávou.
*   **`edit(M_Games $game)`**:
    *   (Admin) Zobrazí formulář pro úpravu existující hry.
    *   Načítá data hry a jejích vztahů (obrázky, tagy, ceny) do formuláře.
    *   Poskytuje data pro výběrová pole (vývojáři, tagy, platformy, obchody).
    *   Připravuje data pro "breadcrumbs".
*   **`update(Request $request, M_Games $game)`**:
    *   (Admin) Zpracovává data odeslaná z formuláře pro úpravu existující hry.
    *   Validuje vstupní data.
    *   Aktualizuje záznam hry a jejích souvisejících dat v databázi v rámci databázové transakce (včetně mazání starých a přidávání nových obrázků/cen).
    *   Přesměrovává zpět na stránku úpravy hry s potvrzovací zprávou.
*   **`destroy(M_Games $game)`**:
    *   (Admin) Odstraní záznam konkrétní hry a všech jejích souvisejících dat (obrázky, ceny, recenze, pivot tabulky) z databáze v rámci databázové transakce.
    *   Přesměrovává na stránku "discover" (nebo admin seznam her) s potvrzovací zprávou.
*   **`destroyGameImage(M_GameImages $image)`**:
    *   (Admin) Odstraní konkrétní obrázek hry jak ze souborového systému (storage), tak z databáze.
    *   Přesměrovává zpět na předchozí stránku s potvrzovací zprávou.
*   **`adminIndex(Request $request)`**:
    *   (Admin) Zobrazí seznam všech her pro správu v administrátorském rozhraní.
    *   Načítá hry s paginací.
    *   Připravuje data pro "breadcrumbs".

### 5. `App\Http\Controllers\C_ReviewController`

Správa uživatelských recenzí her.

*   **`__construct()`**:
    *   Konstruktor třídy, který aplikuje `auth` middleware, takže pouze přihlášení uživatelé mohou spravovat recenze.
*   **`store(Request $request, M_Games $game)`**:
    *   Uloží novou recenzi pro konkrétní hru od přihlášeného uživatele.
    *   Validuje vstupní data (hodnocení, titulek, komentář).
    *   Kontroluje, zda uživatel již hru nerecenzoval (volitelně může umožnit editaci).
    *   Přesměrovává zpět na stránku hry s potvrzovací zprávou.
*   **`update(Request $request, M_Reviews $review)`**:
    *   Aktualizuje existující recenzi.
    *   Provádí autorizaci (pouze vlastník recenze nebo admin ji může upravit).
    *   Validuje vstupní data.
    *   Přesměrovává zpět na předchozí stránku s potvrzovací zprávou.
*   **`destroy(M_Reviews $review)`**:
    *   Odstraní existující recenzi.
    *   Provádí autorizaci (pouze vlastník recenze nebo admin ji může smazat).
    *   Přesměrovává zpět na předchozí stránku s potvrzovací zprávou.

### 6. `App\Http\Controllers\C_Search`

Zpracování vyhledávání her.

*   **`index(Request $request)`**:
    *   Zobrazí stránku s výsledky vyhledávání na základě poskytnutých parametrů.
    *   Validuje vstupní parametry (dotaz, tagy, řazení, platforma, cenové rozpětí).
    *   Sestavuje dotaz do databáze pro filtrování a řazení her.
    *   Rozlišuje viditelnost her pro běžné uživatele a administrátory.
    *   Zobrazuje výsledky s paginací.
    *   Poskytuje data pro filtry (všechny tagy, všechny platformy).
    *   Připravuje data pro "breadcrumbs".

### 7. `App\Http\Controllers\C_TagPageController`

Zobrazení stránky pro konkrétní tag.

*   **`show(M_Tags $tag)`**:
    *   Zobrazí stránku s hrami, které jsou označeny konkrétním tagem.
    *   Načítá související data tagu a jeho her (obrázky, ceny, vývojář) pomocí "eager loading".
    *   Zobrazuje hry s daným tagem s paginací.
    *   Připravuje data pro "breadcrumbs".

### 8. `App\Http\Controllers\C_WishlistController`

Správa seznamu přání (wishlistu) uživatele.

*   **`__construct()`**:
    *   Konstruktor třídy, který aplikuje `auth` middleware, takže pouze přihlášení uživatelé mohou spravovat svůj wishlist.
*   **`add(M_Games $game)`**:
    *   Přidá konkrétní hru do wishlistu přihlášeného uživatele.
    *   Kontroluje, zda hra již ve wishlistu není.
    *   Přesměrovává zpět na předchozí stránku s potvrzovací/informativní zprávou.
*   **`remove(M_Games $game)`**:
    *   Odebere konkrétní hru z wishlistu přihlášeného uživatele.
    *   Kontroluje, zda hra ve wishlistu skutečně je.
    *   Přesměrovává zpět na předchozí stránku s potvrzovací/informativní zprávou.
*   **`index()`**:
    *   Zobrazí stránku se seznamem her ve wishlistu přihlášeného uživatele.
    *   Načítá hry z wishlistu s paginací a souvisejícími daty.
    *   Připravuje data pro "breadcrumbs".

### 9. `App\Http\Controllers\Admin\C_SiteInfo`
Správa a zobrazení informací o stránce.
*    **`index()`**:
     *   Zobrazí stránku s informacemi o webu, jako jsou počty her, uživatelů atd.
     *   Sbírá statistická data z různých modelů.
     *   Připravuje data pro "breadcrumbs".

---

## Vlastní Vytvořené Knihovny a Komponenty

### 1. View Komponenta: `App\View\Components\Layouts\V_Main`

Hlavní layout komponenta, která obaluje většinu stránek v aplikaci.

*   **`__construct($title = 'Game Application', $breadcrumbs = [])`**:
    *   Konstruktor komponenty.
    *   Přijímá `String $title` pro titulek stránky (výchozí hodnota 'Game Application').
    *   Přijímá `Array $breadcrumbs` pro generování drobečkové navigace (výchozí prázdné pole).
*   **`render()`**:
    *   Metoda zodpovědná za vykreslení pohledu (view) komponenty.
    *   Vrací pohled `resources/views/components/layouts/v-main.blade.php`.

### 1. Konfigurační Soubor: `App\Configuration`

Tento soubor obsahuje pouze jedinou proměnnou sloužící k nastavení stránkování

*   **`$pagination`**:
    *   Proměnná určující počet položek na jednu stránku při použití stránkování.
    *   Může nabývat hodnot -9223372036854775808 až 9223372036854775807 (nebo -2147483648 až 2147483647, dle procesoru).
    *   Stránkování po příliš mnoho položkách ztrácí význam, jelikož tím ztrácíme výhody vyšší přehlednosti a lepšího výkonu.

---

## Využité Externí Nástroje a Knihovny

### 1. Laravel Framework

*   **Název knihovny**: Laravel Framework
*   **Verze knihovny**: 12.3.0
*   **Autor knihovny**: Taylor Otwell & Komunita Laravel
*   **Licence knihovny**: MIT
*   **Link na knihovnu**: [https://laravel.com/](https://laravel.com/)

### 2. Tailwind CSS

*   **Název knihovny**: Tailwind CSS
*   **Verze knihovny**: ^3.1.0
*   **Autor knihovny**: Tailwind Labs
*   **Licence knihovny**: MIT
*   **Link na knihovnu**: [https://tailwindcss.com/](https://tailwindcss.com/)

### 3. Alpine.js

*   **Název knihovny**: Alpine.js
*   **Verze knihovny**: ^3.4.2
*   **Autor knihovny**: Caleb Porzio & Komunita
*   **Licence knihovny**: MIT
*   **Link na knihovnu**: [https://alpinejs.dev/](https://alpinejs.dev/)

### 4. Vite

*   **Název knihovny**: Vite
*   **Verze knihovny**: ^6.0.11
*   **Autor knihovny**: Evan You & Komunita Vite
*   **Licence knihovny**: MIT
*   **Link na knihovnu**: [https://vitejs.dev/](https://vitejs.dev/)

### 5. Quill Rich Text Editor

*   **Název knihovny**: Quill
*   **Verze knihovny**: ^2.0.3
*   **Autor knihovny**: Slab Inc. & Komunita
*   **Licence knihovny**: BSD-3-Clause
*   **Link na knihovnu**: [https://quilljs.com/](https://quilljs.com/)

### 6. Tailwind CSS Plugins

*   **`@tailwindcss/aspect-ratio`**:
    *   **Verze**: ^0.4.2
    *   **Autor**: Tailwind Labs
    *   **Licence**: MIT
    *   **Link**: [https://github.com/tailwindlabs/tailwindcss-aspect-ratio](https://github.com/tailwindlabs/tailwindcss-aspect-ratio)
*   **`@tailwindcss/forms`**:
    *   **Verze**: ^0.5.2
    *   **Autor**: Tailwind Labs
    *   **Licence**: MIT
    *   **Link**: [https://github.com/tailwindlabs/tailwindcss-forms](https://github.com/tailwindlabs/tailwindcss-forms)
*   **`@tailwindcss/typography`**:
    *   **Verze**: ^0.5.16
    *   **Autor**: Tailwind Labs
    *   **Licence**: MIT
    *   **Link**: [https://github.com/tailwindlabs/tailwindcss-typography](https://github.com/tailwindlabs/tailwindcss-typography)

### 7. Další Frontend Nástroje (Dev Dependencies)

*   **Autoprefixer**: ^10.4.2 (PostCSS plugin pro přidání vendor prefixů)
*   **Axios**: ^1.8.2 (HTTP klient pro prohlížeč a node.js)
*   **PostCSS**: ^8.4.31 (Nástroj pro transformaci CSS pomocí JavaScript pluginů)
*   **Laravel Vite Plugin**: ^1.2.0 (Integrace Vite s Laravelem)
*   **Concurrently**: ^9.0.1 (Nástroj pro spouštění více příkazů současně)

---

## Konfigurační Proměnné

Popis vybraných důležitých konfiguračních proměnných, primárně ze souboru `.env`.

### Proměnné ze souboru `.env`

*   **`APP_NAME`**:
    *   **Význam**: Název aplikace.
    *   **Účel**: Zobrazuje se v titulcích stránek, emailech a dalších místech, kde je potřeba identifikovat aplikaci.
    *   **Možné hodnoty**: Řetězec (např. "GamePlatform", "Moje Herní Databáze").

*   **`APP_ENV`**:
    *   **Význam**: Prostředí, ve kterém aplikace běží.
    *   **Účel**: Ovlivňuje chování některých částí Laravelu (např. zobrazování chyb, logování).
    *   **Možné hodnoty**: `local` (pro lokální vývoj), `staging` (pro testovací prostředí), `production` (pro produkční nasazení).

*   **`APP_KEY`**:
    *   **Význam**: Šifrovací klíč aplikace.
    *   **Účel**: Používá se pro šifrování session, cookies a dalších citlivých dat. Musí být nastaven a unikátní pro každou instalaci. Generuje se příkazem `php artisan key:generate`.
    *   **Možné hodnoty**: 32 znaků dlouhý náhodný řetězec s prefixem `base64:`.

*   **`APP_DEBUG`**:
    *   **Význam**: Zapíná/vypíná debugovací mód.
    *   **Účel**: V debug módu se zobrazují detailní chybové hlášky. Na produkci by měl být vždy vypnutý (`false`).
    *   **Možné hodnoty**: `true`, `false`.

*   **`APP_URL`**:
    *   **Význam**: Hlavní URL adresa aplikace.
    *   **Účel**: Používá se pro generování absolutních URL adres v příkazové řádce, emailech atd.
    *   **Možné hodnoty**: Platná URL adresa (např. `http://localhost`, `https://mojedomena.cz`).

*   **`DB_CONNECTION`**:
    *   **Význam**: Typ databázového připojení.
    *   **Účel**: Určuje, jaký databázový systém Laravel použije.
    *   **Možné hodnoty**: `mysql`, `pgsql`, `sqlite`, `sqlsrv`. V tomto projektu je pravděpodobně `mysql`.

*   **`DB_HOST`**:
    *   **Význam**: Adresa databázového serveru.
    *   **Účel**: Pro připojení k databázi.
    *   **Možné hodnoty**: IP adresa nebo hostname (např. `127.0.0.1`, `localhost`, `db.example.com`).

*   **`DB_PORT`**:
    *   **Význam**: Port databázového serveru.
    *   **Účel**: Pro připojení k databázi.
    *   **Možné hodnoty**: Číslo portu (např. `3306` pro MySQL, `5432` pro PostgreSQL).

*   **`DB_DATABASE`**:
    *   **Význam**: Název databáze.
    *   **Účel**: Specifikuje databázi, ke které se má aplikace připojit.
    *   **Možné hodnoty**: Název existující databáze (např. `gameplatform_db`).

*   **`DB_USERNAME`**:
    *   **Význam**: Uživatelské jméno pro přístup k databázi.
    *   **Účel**: Autentizace vůči databázovému serveru.
    *   **Možné hodnoty**: Platné uživatelské jméno (např. `root`, `gameuser`).

*   **`DB_PASSWORD`**:
    *   **Význam**: Heslo pro přístup k databázi.
    *   **Účel**: Autentizace vůči databázovému serveru.
    *   **Možné hodnoty**: Heslo k danému uživatelskému jménu.

*   **`FILESYSTEM_DISK`** (dříve `FILESYSTEM_DRIVER`):
    *   **Význam**: Výchozí souborový systém (disk), který bude Laravel používat.
    *   **Účel**: Určuje, kam se budou standardně ukládat soubory (např. nahrané obrázky).
    *   **Možné hodnoty**: `local` (lokální úložiště ve složce `storage/app`), `public` (veřejně přístupné lokální úložiště ve složce `storage/app/public`), `s3` (Amazon S3) atd. Pro obrázky her je pravděpodobně nastaveno na `public`.

### Proměnné z `config/app.php` (často přebírané z `.env`)

*   **`'name'` => `env('APP_NAME', 'Laravel')`**:
    *   Viz `APP_NAME` výše.
*   **`'env'` => `env('APP_ENV', 'production')`**:
    *   Viz `APP_ENV` výše.
*   **`'debug'` => `(bool) env('APP_DEBUG', false)`**:
    *   Viz `APP_DEBUG` výše.
*   **`'url'` => `env('APP_URL', 'http://localhost')`**:
    *   Viz `APP_URL` výše.
*   **`'timezone'` => `'UTC'`**:
    *   **Význam**: Časová zóna aplikace.
    *   **Účel**: Ovlivňuje, jak se ukládají a zobrazují data a časy.
    *   **Možné hodnoty**: Platný identifikátor časové zóny (např. `'UTC'`, `'Europe/Prague'`).
*   **`'locale'` => `'en'`**:
    *   **Význam**: Výchozí jazyk aplikace.
    *   **Účel**: Používá se pro lokalizaci (překlady).
    *   **Možné hodnoty**: Kód jazyka (např. `'en'`, `'cs'`).

---

## Zdroje a Citace

Při vývoji této aplikace byly využity následující zdroje a online fóra:

### Oficiální Dokumentace

*   **Laravel 12.x Documentation**: [https://laravel.com/docs/12.x](https://laravel.com/docs/12.x)
*   **Tailwind CSS v2 Documentation**: [https://v3.tailwindcss.com/docs](https://v3.tailwindcss.com/docs)

### Stack Overflow a Komunitní Fóra

*   Otázka ohledně `@push` v Blade:
    *   [Stack Overflow: laravel push not working in create category blade php](https://stackoverflow.com/questions/46189189/laravel-push-not-working-in-create-category-blade-php)
*   Řešení problému s proměnnou `$slot` v Livewire:
    *   [Stack Overflow: livewire 2 2 undefined variable slot in app blade php](https://stackoverflow.com/questions/64088056/livewire-2-2-undefined-variable-slot-in-app-blade-php)
*   Problém s externí URL v Laravelu:
    *   [Stack Overflow: laravel external url issue](https://stackoverflow.com/questions/41142229/laravel-external-url-issue)
*   Chyby `@apply` v CSS (souvisí s Tailwind CSS konfigurací):
    *   [Stack Overflow: duplicate unknown at rule apply cssunknownatrules errors in vue js project](https://stackoverflow.com/questions/71648391/duplicate-unknown-at-rule-apply-cssunknownatrules-errors-in-vue-js-project)
*   Problém s Quill editorem (souvisí s implementací Quill editoru):
    *   [GitHub Issues (ngx-quill): Issue related to Quill functionality](https://github.com/KillerCodeMonkey/ngx-quill/issues/132)

---

## Závěr

Pro detailnější informace doporučuji nahlédnout přímo do zdrojového kódu, který je dokumentovaný v angličtině.
