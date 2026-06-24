const fs = require('fs');
const path = require('path');

const src = "C:\\Users\\Pagina-Web1\\.gemini\\antigravity-ide\\brain\\d5475e1c-960f-4f19-b8e4-3bd2c5acb3e3\\media__1781708759953.png";
const destDir = "c:\\Users\\Pagina-Web1\\Downloads\\Suraki_HelpDesk-main\\Suraki_HelpDesk-main\\public\\images";
const dest1 = path.join(destDir, 'logo.png');
const dest2 = path.join(destDir, 'favicon.png');

if (!fs.existsSync(destDir)) {
    fs.mkdirSync(destDir, { recursive: true });
}
try {
    fs.copyFileSync(src, dest1);
    fs.copyFileSync(src, dest2);
    console.log("Copied successfully");
} catch(e) {
    console.error("Error copying:", e);
}
