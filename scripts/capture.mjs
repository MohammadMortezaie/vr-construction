import { writeFile } from 'node:fs/promises';

const [url, output, widthArg = '390', heightArg = '844'] = process.argv.slice(2);
const width = Number(widthArg);
const height = Number(heightArg);
const target = await fetch(`http://127.0.0.1:9223/json/new?${encodeURIComponent(url)}`, { method: 'PUT' }).then((response) => response.json());
const socket = new WebSocket(target.webSocketDebuggerUrl);
let nextId = 0;
const pending = new Map();

socket.addEventListener('message', ({ data }) => {
  const message = JSON.parse(data);
  if (!message.id || !pending.has(message.id)) return;
  const { resolve, reject } = pending.get(message.id);
  pending.delete(message.id);
  if (message.error) reject(new Error(message.error.message));
  else resolve(message.result);
});

await new Promise((resolve) => socket.addEventListener('open', resolve, { once: true }));
const send = (method, params = {}) => new Promise((resolve, reject) => {
  const id = ++nextId;
  pending.set(id, { resolve, reject });
  socket.send(JSON.stringify({ id, method, params }));
});

await send('Emulation.setDeviceMetricsOverride', { width, height, deviceScaleFactor: 1, mobile: true, screenWidth: width, screenHeight: height });
await send('Emulation.setTouchEmulationEnabled', { enabled: true, maxTouchPoints: 5 });
await send('Page.enable');
await send('Page.navigate', { url });
await new Promise((resolve) => setTimeout(resolve, 1200));
const metrics = await send('Runtime.evaluate', { expression: 'JSON.stringify({innerWidth, innerHeight, scrollWidth: document.documentElement.scrollWidth, title: document.title})', returnByValue: true });
const shot = await send('Page.captureScreenshot', { format: 'png', fromSurface: true });
await writeFile(output, Buffer.from(shot.data, 'base64'));
console.log(metrics.result.value);
socket.close();
