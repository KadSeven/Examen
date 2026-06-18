@extends('layouts.app')

@section('content')
<style>
  @import url('https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600;700&display=swap');

  .page-500-container {
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

  /* --- Zona de Reparación --- */
  .repair-area {
    width: 100%;
    max-width: 400px;
    height: 180px;
    position: relative;
    margin-bottom: 20px;
    display: flex;
    justify-content: center;
    align-items: flex-end;
  }

  .monster-mechanic {
    width: 120px;
    height: auto;
    fill: #f39c12;
    /* Animación de martilleo o esfuerzo */
    animation: struggle 1s ease-in-out infinite;
  }

  @keyframes struggle {
    0%, 100% { transform: rotate(-5deg) translateY(0); }
    50% { transform: rotate(5deg) translateY(-10px); }
  }

  /* Chispas animadas */
  .spark {
    position: absolute;
    width: 4px;
    height: 4px;
    background: #f1c40f;
    border-radius: 50%;
    opacity: 0;
  }

  .spark-1 { bottom: 60px; left: 45%; animation: spark-anim 1.5s infinite; }
  .spark-2 { bottom: 70px; right: 45%; animation: spark-anim 1.5s infinite 0.5s; }

  @keyframes spark-anim {
    0% { transform: translate(0,0); opacity: 1; }
    100% { transform: translate(20px, -30px); opacity: 0; }
  }

  /* --- Estilos de Texto --- */
  .code-500 {
    font-weight: 800;
    font-size: 80px;
    color: #343a40;
    margin: 0;
    line-height: 1;
  }

  .error-title {
    font-weight: 600;
    font-size: 20px;
    color: #495057; /* Gris oscuro para algo técnico */
    text-transform: uppercase;
    margin-bottom: 15px;
  }

  .error-desc {
    color: #6c757d;
    max-width: 450px;
    text-align: center;
    margin-bottom: 30px;
  }

  .btn-admin {
    background-color: #f39c12; /* Naranja como pediste */
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

<div class="page-500-container">
  
  <div class="repair-area">
    <div class="spark spark-1"></div>
    <div class="spark spark-2"></div>
    
    <svg class="monster-mechanic" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
      <path d="M20 80 Q20 20 50 20 T80 80 Z" />
      <path d="M30 30 L20 10 L40 25 Z" fill="#cf6a17" />
      <path d="M70 30 L80 10 L60 25 Z" fill="#cf6a17" />
      <path d="M35 45 Q40 40 45 45" stroke="black" stroke-width="2" fill="none" /> <path d="M55 45 Q60 40 65 45" stroke="black" stroke-width="2" fill="none" /> <circle cx="40" cy="55" r="5" fill="white" />
      <circle cx="60" cy="55" r="5" fill="white" />
      <circle cx="40" cy="55" r="2" fill="black" />
      <circle cx="60" cy="55" r="2" fill="black" />
      <path d="M45 75 Q50 65 55 75" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" />
      <rect x="30" y="80" width="10" height="15" rx="5" fill="#333" />
      <rect x="60" y="80" width="10" height="15" rx="5" fill="#333" />
      <rect x="70" y="50" width="6" height="20" fill="#95a5a6" transform="rotate(45 70 50)" />
      <circle cx="85" cy="50" r="5" fill="#95a5a6" />
    </svg>
  </div>

  <div class="code-500">500</div>
  <div class="error-title">Fallo en los Engranajes</div>
  
  <p class="error-desc">
    ¡Rayos! Algo se rompió internamente. Nuestro monstruo está intentando repararlo, pero parece que tomará un momento.<br>
    <strong>Intenta recargar la página en unos segundos.</strong>
  </p>

  <a href="{{ route('home') }}" class="btn-admin">
    <span>&#8635;</span> Reintentar / Ir al Inicio
  </a>
</div>
@endsection