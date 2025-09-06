const fs = require('fs');
const axios = require('axios');

const API_KEY = '8f07a5f8a047addadf8e7d09b0730043';
const SCRAPER_URL = `https://api.scraperapi.com?api_key=${API_KEY}&url=https://integration.jps.go.cr/api/App/nuevostiempos/last`;
const MAX_RETRIES = 5;
const RETRY_DELAY = 5000; // 5 segundos
const RESULTADOS_PATH = '/var/www/ticotiempos/resultados.txt';
const LOG_PATH = '/var/www/ticotiempos/resultados_log.txt';

function log(mensaje) {
  const registro = `[${new Date().toISOString()}] ${mensaje}\n`;
  fs.appendFileSync(LOG_PATH, registro, 'utf8');
}

// Ejecutar la función principal al correr el script
obtenerResultados();

function esRespuestaValida(data) {
  return data && typeof data === 'object' && (data.hasOwnProperty('manana') || data.hasOwnProperty('mediaTarde') || data.hasOwnProperty('tarde'));
}

function inicializarArchivoResultados() {
  if (!fs.existsSync(RESULTADOS_PATH)) {
    fs.writeFileSync(RESULTADOS_PATH, JSON.stringify({ mensaje: 'Inicializado, esperando resultados.' }, null, 2), 'utf8');
    log('Archivo resultados.txt inicializado.');
    console.log('Archivo resultados.txt inicializado.');
  } else {
    log('Archivo resultados.txt ya existe.');
  }
}

async function obtenerResultados(reintento = 1) {
  inicializarArchivoResultados();
  try {
    const response = await axios.get(SCRAPER_URL, {
      timeout: 30000,
      headers: {
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36',
        'Accept': 'application/json,text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        'Referer': 'https://www.jps.go.cr/'
      }
    });
    // Siempre sobrescribe el archivo, aunque los datos sean iguales
    fs.writeFileSync(RESULTADOS_PATH, JSON.stringify(response.data, null, 2), 'utf8');
    log('Intento de actualización: datos escritos en resultados.txt');
    if (!esRespuestaValida(response.data)) {
      log('Advertencia: Formato de respuesta inválido, pero archivo sobrescrito.');
      throw new Error('Formato de respuesta inválido');
    }
    log('Actualización exitosa de resultados.txt');
    console.log('Archivo resultados.txt actualizado correctamente.');
  } catch (error) {
    let detalles = '';
    if (error.response) {
      detalles = `Status: ${error.response.status}, Body: ${JSON.stringify(error.response.data)}`;
    } else if (error.request) {
      detalles = 'No hubo respuesta del servidor (request enviado, sin respuesta).';
    } else {
      detalles = `Error: ${error.message}`;
    }
    log(`Intento ${reintento}: Error al obtener los resultados: ${error.message} | ${detalles}`);
    console.error(`Intento ${reintento}: Error al obtener los resultados:`, error.message);
    if (detalles) console.error(detalles);
    if (reintento < MAX_RETRIES) {
      console.log(`Reintentando en ${RETRY_DELAY / 1000} segundos...`);
      setTimeout(() => obtenerResultados(reintento + 1), RETRY_DELAY);
    } else {
      log('No se pudo obtener los resultados después de varios intentos.');
      console.error('No se pudo obtener los resultados después de varios intentos.');
    }
  }
}

