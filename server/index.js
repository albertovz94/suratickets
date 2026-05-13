const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const { PrismaClient } = require('@prisma/client');

const app = express();
const prisma = new PrismaClient();
const server = http.createServer(app);

// Configuración de Sockets
const io = new Server(server, {
  cors: { origin: "*" } // En producción limitar a la IP de la PC
});

app.use(cors());
app.use(express.json());

// --- ENDPOINTS ---

// 1. Crear nuevo ticket (Kiosco Touch)
app.post('/api/tickets', async (req, res) => {
  const { departamento } = req.body;
  try {
    // Obtener el último número del día para ese departamento
    const ultimoTicket = await prisma.ticket.findFirst({
      where: { departamento },
      orderBy: { numero: 'desc' }
    });

    const nuevoNumero = ultimoTicket ? ultimoTicket.numero + 1 : 1;

    const ticket = await prisma.ticket.create({
      data: { numero: nuevoNumero, departamento }
    });

    res.json(ticket);
  } catch (error) {
    res.status(500).json({ error: "Error al crear ticket" });
  }
});

// 2. Llamar Siguiente (Escáner del Carnicero)
app.post('/api/tickets/llamar', async (req, res) => {
  const { codigoBarras } = req.body; // Viene del carnet "OP-001"

  try {
    const result = await prisma.$transaction(async (tx) => {
      // A. Finalizar atención previa del carnicero
      await tx.ticket.updateMany({
        where: { operadorId: codigoBarras, estado: "atendiendo" },
        data: { estado: "finalizado", finalizadoEn: new Date() }
      });

      // B. Buscar el siguiente ticket en espera
      const siguiente = await tx.ticket.findFirst({
        where: { estado: "esperando" },
        orderBy: { creadoEn: 'asc' }
      });

      if (!siguiente) return null;

      // C. Asignar y activar el nuevo ticket
      return await tx.ticket.update({
        where: { id: siguiente.id },
        data: { 
          estado: "atendiendo", 
          llamadoEn: new Date(), 
          operadorId: codigoBarras 
        }
      });
    });

    if (result) {
      // NOTIFICAR A LA TV POR SOCKETS
      io.emit('ticket-llamado', result);
      return res.json(result);
    }

    res.status(404).json({ message: "No hay nadie en cola" });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
});

const PORT = 4000;
server.listen(PORT, () => {
  console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
});