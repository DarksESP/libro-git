
# 🎮 API REST - Gestión de Juegos

## 📘 Descripción
Esta API permite administrar un catálogo de videojuegos, incluyendo sus consolas asociadas.  
Se puede **listar, agregar, editar y eliminar juegos**, además de obtener información **filtrada o paginada**.

La API fue desarrollada en **PHP** con arquitectura **MVC** y conexión a **MySQL**, siguiendo los principios **RESTful**.

---

## 🚀 Endpoints principales

### 🔹 Juegos

| Método | Endpoint | Descripción | Códigos de respuesta |
|--------|----------|-------------|--------------------|
| GET    | /juegos  | Devuelve todos los juegos (puede incluir paginación, orden y filtros). | 200, 400 |
| GET    | /juegos/:id | Devuelve un juego específico por su ID. | 200, 404 |
| POST   | /juegos  | Crea un nuevo juego (requiere nombre, consola, género, etc). | 201, 400 |
| PUT    | /juegos/:id | Actualiza un juego existente. | 200, 400, 404 |
| DELETE | /juegos/:id | Elimina un juego de la base de datos. | 200, 404 
