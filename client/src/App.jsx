import { useState } from 'react';

function App() {
  const [ultimoTicket, setUltimoTicket] = useState(null);

  const generarTicket = async (departamento) => {
    try {
      const response = await fetch('http://localhost:4000/api/tickets', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ departamento })
      });
      
      const data = await response.json();
      setUltimoTicket(data);

      // Limpia el mensaje en pantalla después de 4 segundos
      setTimeout(() => setUltimoTicket(null), 4000);
    } catch (error) {
      console.error("Error al generar el ticket", error);
    }
  };

  return (
    <div className="min-h-screen w-full bg-slate-900 flex flex-col items-center justify-center p-8 relative">
      
      {/* Títulos */}
      <h1 className="text-5xl text-white font-bold mb-4 text-center tracking-tight">
        Bienvenidos a Hiper Suraki
      </h1>
      <p className="text-2xl text-slate-400 mb-16 text-center">
        Toque el departamento para tomar su turno
      </p>

      {/* Contenedor de Botones (Flexbox para que se pongan uno al lado del otro) */}
      <div className="flex flex-row gap-8 mb-12">
        
        {/* Botón 1: Carnicería y Charcutería (Rojo) */}
        <button
          onClick={() => generarTicket('Carniceria y Charcuteria')}
          className="bg-red-600 hover:bg-red-500 text-white font-black text-3xl py-12 px-6 rounded-3xl shadow-[0_10px_0_0_#7f1d1d] active:shadow-none active:translate-y-[10px] transition-all flex flex-col items-center justify-center gap-4 w-80 h-72"
        >
          <span className="text-7xl">🥩</span>
          <span className="text-center leading-tight">Carnicería y<br/>Charcutería</span>
        </button>

        {/* Botón 2: Pollería (Naranja/Ámbar) */}
        <button
          onClick={() => generarTicket('Polleria')}
          className="bg-amber-500 hover:bg-amber-400 text-white font-black text-3xl py-12 px-6 rounded-3xl shadow-[0_10px_0_0_#b45309] active:shadow-none active:translate-y-[10px] transition-all flex flex-col items-center justify-center gap-4 w-80 h-72"
        >
          <span className="text-7xl">🍗</span>
          <span>Pollería</span>
        </button>

        {/* Botón 3: Pescadería (Azul) */}
        <button
          onClick={() => generarTicket('Pescaderia')}
          className="bg-blue-600 hover:bg-blue-500 text-white font-black text-3xl py-12 px-6 rounded-3xl shadow-[0_10px_0_0_#1e3a8a] active:shadow-none active:translate-y-[10px] transition-all flex flex-col items-center justify-center gap-4 w-80 h-72"
        >
          <span className="text-7xl">🐟</span>
          <span>Pescadería</span>
        </button>

      </div>

      {/* Alerta del Ticket Generado (Flotante en el centro) */}
      {ultimoTicket && (
        <div className="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white px-20 py-12 rounded-3xl shadow-[0_0_50px_rgba(0,0,0,0.5)] text-center animate-bounce z-50 border-8 border-slate-100 flex flex-col items-center">
          <p className="text-slate-500 text-2xl font-bold mb-2 uppercase tracking-widest">
            {ultimoTicket.departamento}
          </p>
          <p className="text-[10rem] leading-none font-black text-slate-800 my-4 drop-shadow-lg">
            #{ultimoTicket.numero}
          </p>
          <p className="text-slate-500 text-xl mt-4 font-medium">Por favor, espere su llamado</p>
        </div>
      )}

      {/* Overlay oscuro para bloquear clics cuando sale el ticket */}
      {ultimoTicket && (
        <div className="absolute inset-0 bg-black bg-opacity-60 z-40"></div>
      )}

    </div>
  );
}

export default App;