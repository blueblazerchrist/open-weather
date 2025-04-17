# 🌤️ Weather App - Full Stack

Aplicación full-stack que permite consultar el clima actual y la previsión de hasta 5 días usando Laravel, React, Redux y Tailwind CSS.

---

## 🚀 Tecnologías utilizadas

### Backend
- Laravel 12
- PHP 8.3+
- OpenWeatherMap API

### Frontend
- React 19 + Vite
- TypeScript
- Redux
- Tailwind CSS v3
- Axios

---

## 📦 Estructura del proyecto

## 🧪 Endpoints

### 📌 Clima actual (`POST /api/weather/current`)
**Body:**
```json
{
  "location": "BogotáCO"
}

```
**Response:**
```json
{
  "city": "Bogotá (CO)",
  "date": "Apr 15 2025",
  "weather": "clear sky",
  "temperature": "72.5°F",
  "icon": "http://..."
}

```

### 📌 Clima actual (`POST /api/weather/current`)
**Body:**
```json
{
  "location": "BogotáCO",
  "days": 3
}

```
**Response:**
```json
{
  "city": "Bogotá (CO)",
  "forecast": [
    {
      "date": "Apr 16 2025",
      "weather": "light rain",
      "temperature": "70.1°F",
      "icon": "http://..."
    },
    ...
  ]
}

```
## ⚙️ Instalación

## 🔧 Backend (Laravel) docker

- cd backend/api-open-weather
- cp .env.example .env
- composer install
- php artisan key:generate
- php artisan serve
- generar llave del servicio https://openweathermap.org/
- Agrégala en .env OPENWEATHER_API_KEY=tu_api_key_aqui

## 🔧 Frontend (React)

- cd frontend
- npm install
- npm run dev


**📝 Nota:** El proyecto contiene dominios para su funcionamiento 

**📝 Nota final:** El prpyecto backend tambien tiene una configuracion de docker para su funcionamiento si se tiene instalado docker solo debes ejecutar el siguiente comando.

---
- sudo docker compose up -d
---
