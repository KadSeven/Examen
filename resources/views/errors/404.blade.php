@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap');

  .page-404-container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    min-height: calc(100vh - 60px);
    background: #f4f6f9;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
  }

  /* --- Área donde camina el monstruo --- */
  .walking-area {
    width: 100%;
    max-width: 600px;
    height: 200px;
    position: relative;
    margin-bottom: 20px;
  }

  .monster-wrapper {
    position: absolute;
    width: 120px;
    bottom: 0;
    /* Animación de caminar de lado a lado */
    animation: walk-back-and-forth 8s linear infinite;
  }

  /* --- El Monstruo Naranja --- */
  .monster-orange {
    width: 100%;
    height: auto;
    fill: #f39c12; /* Tu naranja de advertencia */
    /* Animación de balanceo al caminar */
    animation: bounce-walk 0.5s ease-in-out infinite;
  }

  /* Animación: Desplazamiento horizontal */
  @keyframes walk-back-and-forth {
    0% { left: 0%; transform: scaleX(1); }
    45% { transform: scaleX(1); }
    50% { left: calc(100% - 120px); transform: scaleX(-1); }
    95% { transform: scaleX(-1); }
    100% { left: 0%; transform: scaleX(1); }
  }

  /* Animación: Balanceo arriba y abajo */
  @keyframes bounce-walk {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
  }

  /* --- Estilo del Texto --- */
  .code-404 {
    font-weight: 800;
    font-size: 80px;
    color: #343a40;
    margin: 0;
    line-height: 1;
  }

  .error-title {
    font-weight: 600;
    font-size: 20px;
    color: #f39c12;
    text-transform: uppercase;
    margin-bottom: 15px;
  }

  .error-desc {
    color: #6c757d;
    max-width: 400px;
    text-align: center;
    margin-bottom: 30px;
  }

  .btn-admin {
    font-weight: 600;
    font-size: 14px;
    color: #ffffff;
    /* Cambiado a naranja para combinar con el monstruo */
    background-color: #f39c12; 
    padding: 12px 25px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(243, 156, 18, 0.2);
  }

  .btn-admin:hover {
    /* Un naranja un poco más oscuro al pasar el mouse */
    background-color: #e67e22; 
    color: #ffffff;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(243, 156, 18, 0.3);
  }

  .btn-admin:active {
    transform: translateY(0);
  }
</style>

<div class="page-404-container">
  
  <div class="walking-area">
    <div class="monster-wrapper">
      <svg class="monster-orange" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 80 Q20 20 50 20 T80 80 Z" />
        <path d="M30 30 L20 10 L40 25 Z" fill="#e67e22" />
        <path d="M70 30 L80 10 L60 25 Z" fill="#e67e22" />
        <circle cx="40" cy="45" r="6" fill="white" />
        <circle cx="40" cy="45" r="3" fill="black" />
        <circle cx="60" cy="45" r="6" fill="white" />
        <circle cx="60" cy="45" r="3" fill="black" />
        <path d="M40 65 Q50 75 60 65" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" />
        <rect x="30" y="80" width="10" height="15" rx="5" fill="#333" />
        <rect x="60" y="80" width="10" height="15" rx="5" fill="#333" />
      </svg>
    </div>
  </div>

  <div class="code-404">404</div>
  <div class="error-title">¡Se nos escapó la página!</div>
  
  <p class="error-desc">
    Parece que nuestro pequeño monstruo naranja se llevó la sección que buscabas a dar un paseo.
  </p>

  <a href="{{ route('home') }}" class="btn-admin">
    Volver al Panel de Control
  </a>
</div>
@endsection