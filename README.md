# Biblioteca PHP - Projecte Web

Aquest projecte és una aplicació web en PHP per gestionar una biblioteca, amb usuaris, materials i préstecs. Inclou mètodes màgics en les classes (`__get`, `__set`, `__toString`, `__call`) i un sistema bàsic d’enrutament a través de `index.php`.

# Repositori GitHub:
https://github.com/eto-4/biblioteca

---

## Estructura del Projecte

/biblioteca
│
├─ /classes # Classes PHP (Usuari, Biblioteca, Material, etc.)
├─ /interfaces # Interfaces
├─ /traits # Traits (Auditoria, etc.)
├─ /exceptions # Excepcions personalitzades
├─ /views # Vistes (usuaris.php, usuari_detall.php, materials.php, material_detall.php)
├─ autoload.php # Autoload de classes
├─ index.php # Punt d’entrada i enrutament
└─ style.css # Estils generals de la web

---

## Instruccions Ràpides

1. **Instal·lació local**  
   - Col·loca el projecte al teu servidor local (XAMPP, MAMP, etc.).  
   - Assegura’t de tenir PHP >= 8.0.  
   - Accedeix a `http://localhost/biblioteca` (ajusta la ruta segons el teu servidor).

2. **Carrega inicial de dades**  
   - A `classes/init_data.php` es creen usuaris i materials de prova.  
   - L’objecte `$biblioteca` s’instancia a `index.php`.

3. **Navegació**  
   - Llista d’usuaris: `index.php?page=usuaris`  
   - Detall d’usuari: `index.php?page=usuari&nom=NomDelUsuari`  
   - Llista de materials: `index.php?page=materials`  
   - Detall de material: `index.php?page=material_detall&id=IDMaterial`

4. **Enrutament**  
   - `index.php` carrega les vistes segons el paràmetre `page`.  
   - Si no existeix la pàgina, mostra `views/404.php`.

5. **Estils**  
   - `style.css` conté estils globals, taules, detalls d’usuari/material, i responsivitat.  
   - Els detalls d’usuari i material es centren a la pantalla amb caixes blanques i ombra.

6. **Classes Clau**  
   - `Usuari`: gestió de nom, email, materials prestats, mètodes màgics (`__get`, `__set`, `__toString`).  
   - `Material`: informació dels materials (ID, títol, tipus, disponibilitat).  
   - `Biblioteca`: emmagatzema i gestiona usuaris i materials, cerca per nom o ID.

---

## Autor
Aleix 
Projecte desenvolupat per proves de PHP i maneig de classes orientades a objectes amb funcionalitat