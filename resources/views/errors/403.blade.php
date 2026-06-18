@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap');

  .page-403-container {
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

  /* --- Zona de Vigilancia --- */
  .guard-area {
    width: 100%;
    max-width: 500px;
    height: 180px;
    position: relative;
    margin-bottom: 20px;
    border-bottom: 3px solid #dee2e6; /* Una línea que simula el suelo */
  }

  .monster-guard-wrapper {
    position: absolute;
    width: 110px;
    bottom: 0;
    /* Animación de patrullaje (más corto que el 404) */
    animation: patrol 5s ease-in-out infinite;
  }

  .monster-orange {
    width: 100%;
    height: auto;
    fill: #e67e22; /* Un naranja un poco más oscuro/fuerte para el 403 */
    animation: bounce-guard 0.6s ease-in-out infinite;
  }

  /* Animación: Patrullaje de vigilante */
  @keyframes patrol {
    0% { left: 20%; transform: scaleX(1); }
    45% { transform: scaleX(1); }
    50% { left: 70%; transform: scaleX(-1); }
    95% { transform: scaleX(-1); }
    100% { left: 20%; transform: scaleX(1); }
  }

  @keyframes bounce-guard {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); }
  }

  /* --- Estilos de Texto (Igual que tus otros errores para que combine) --- */
  .code-403 {
    font-weight: 800;
    font-size: 80px;
    color: #343a40;
    margin: 10px 0 0;
    line-height: 1;
  }

  .error-title {
    font-weight: 600;
    font-size: 20px;
    color: #d9534f; /* Rojo para denegar el paso */
    text-transform: uppercase;
    margin-bottom: 15px;
  }

  .error-desc {
    color: #6c757d;
    max-width: 450px;
    text-align: center;
    margin-bottom: 30px;
    line-height: 1.6;
  }

  .error-desc strong {
    color: #343a40;
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

<div class="page-403-container">
  
  <div class="guard-area">
    <div class="monster-guard-wrapper">
      <svg class="monster-orange" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
        <path d="M20 80 Q20 20 50 20 T80 80 Z" />
        <path d="M25 35 L10 20 L35 30 Z" fill="#cf6a17" />
        <path d="M75 35 L90 20 L65 30 Z" fill="#cf6a17" />
        <rect x="32" y="42" width="16" height="4" rx="2" fill="black" /> <rect x="52" y="42" width="16" height="4" rx="2" fill="black" /> <circle cx="40" cy="52" r="5" fill="white" />
        <circle cx="40" cy="52" r="2.5" fill="black" />
        <circle cx="60" cy="52" r="5" fill="white" />
        <circle cx="60" cy="52" r="2.5" fill="black" />
        <line x1="40" y1="68" x2="60" y2="68" stroke="white" stroke-width="4" stroke-linecap="round" />
        <rect x="30" y="80" width="12" height="15" rx="4" fill="#333" />
        <rect x="58" y="80" width="12" height="15" rx="4" fill="#333" />
        <circle cx="50" cy="35" r="6" fill="#f1c40f" />
      </svg>
    </div>
  </div>

  <div class="code-403">403</div>
  <div class="error-title">Acceso Restringido</div>
  
  <p class="error-desc">
    ¡Alto ahí! Nuestro guardián naranja no tiene tu nombre en la lista de invitados para esta sección.<br>
    <strong>No tienes permisos suficientes para cruzar esta compuerta.</strong>
  </p>

  <a href="{{ route('home') }}" class="btn-admin">
    <span>&#8592;</span> Regresar al Inicio
</a>
</div>
@endsection   