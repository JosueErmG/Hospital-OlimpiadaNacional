function ChangeTheme() {
    var theme = document.documentElement.getAttribute("data-theme");
    var newTheme = theme == "light" ? "dark" : "light";
    document.documentElement.setAttribute("data-theme", newTheme);
    document.cookie = "theme=" + newTheme;
}
