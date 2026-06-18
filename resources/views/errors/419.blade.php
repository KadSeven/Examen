@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap');

  .page-419-container {
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

  /* --- Zona de Espera --- */
  .waiting-area {
    width: 100%;
    max-width: 400px;
    height: 180px;
    position: relative;
    display: flex;
    justify-content: center;
    align-items: flex-end;
    margin-bottom: 20px;
  }

  .monster-waiting {
    width: 110px;
    height: auto;
    fill: #f39c12;
    /* Animación de suspiro/espera lenta */
    animation: sigh 3s ease-in-out infinite;
  }

  @keyframes sigh {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05) translateY(5px); }
  }

  .hourglass {
    font-size: 40px;
    position: absolute;
    right: 25%;
    bottom: 20px;
    animation: flip 4s infinite;
  }

  @keyframes flip {
    0%, 90% { transform: rotate(0); }
    100% { transform: rotate(180deg); }
  }

  /* --- Estilos de Texto --- */
  .code-419 {
    font-weight: 800;
    font-size: 80px;
    color: #343a40;
    margin: 0;
    line-height: 1;
  }

  .error-title {
    font-weight: 600;
    font-size: 20px;
    color: #e67e22;
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

  .btn-admin {
    background-color: #f39c12;
    color: white;
    padding: 12px 25px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 600;
    transition: 0.3s;
    border: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .btn-admin:hover {
    background-color: #e67e22;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
  }
</style>

<div class="page-419-container">
  
  <div class="waiting-area">
    <div class="hourglass">⏳</div>
    
    <svg class="monster-waiting" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 80 Q20 20 50 20 T80 80 Z" />
      <path d="M30 30 L15 25 L35 32 Z" fill="#cf6a17" />
      <path d="M70 30 L85 25 L65 32 Z" fill="#cf6a17" />
      <path d="M30 50 L45 50" stroke="black" stroke-width="3" /> 
      <path d="M55 50 L70 50" stroke="black" stroke-width="3" />
      <circle cx="35" cy="65" r="5" fill="#f39c12" filter="brightness(0.9)" />
      <circle cx="65" cy="65" r="5" fill="#f39c12" filter="brightness(0.9)" />
      <circle cx="50" cy="70" r="3" fill="white" />
      <path d="M20 80 L40 80 L45 90 L15 90 Z" fill="#333" />
      <path d="M60 80 L80 80 L85 90 L55 90 Z" fill="#333" />
    </svg>
  </div>

  <div class="code-419">419</div>
  <div class="error-title">Sesión Caducada</div>
  
  <p class="error-desc">
    ¡Rayos! El tiempo voló y tu sesión se quedó dormida.<br>
    <strong>Por seguridad, refresca la página para continuar con lo que estabas haciendo.</strong>
  </p>

  <a href="{{ url()->previous() }}" class="btn-admin">
    <span>&#8635;</span> Refrescar y Reintentar
  </a>
</div>
@endsection