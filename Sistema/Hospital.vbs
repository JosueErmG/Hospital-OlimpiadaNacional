Dim fs
Set fs = CreateObject("Scripting.FileSystemObject")

dir = fs.GetParentFolderName(WScript.ScriptFullName)
If (fs.FileExists(dir + "/DesktopApp/Hospital-win32-ia32/Hospital.exe")) Then
    WScript.CreateObject("WScript.Shell").Run(dir + "/DesktopApp/Hospital-win32-ia32/Hospital.exe")
Else
    MsgBox("Hola," + chr(13)+chr(10) + "Para ejecutar la aplicación, descomprima Sistema\DesktopApp.7z" + chr(13)+chr(10) + "Gracias.")
End If