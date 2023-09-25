const electron = require("electron");
const { app, globalShortcut, BrowserWindow } = electron;

let window;

app.on("ready", () => {
    window = new BrowserWindow({
        minWidth: 410,
        minHeight: 693,
        
        title: "Hospital"
    });

    window.loadURL("http://g-hospital.infinityfreeapp.com");
    
    window.setMenu(null)

    window.on("closed", () => {
        window = null;
    });

    app.on("window-all-closed", () => app.quit())

    app.on("browser-window-focus", function () {
        globalShortcut.register("CommandOrControl+R", () => window.reload());
        globalShortcut.register("F5", () => window.reload());
    });
    
    app.on("browser-window-blur", function () {
        globalShortcut.unregister("CommandOrControl+R");
        globalShortcut.unregister("F5");
    });
});
