function ChangeTheme(bDark) {
    if (bDark) {
        document.documentElement.style.cssText = `
            --color-background: #282536;
            --color-background-dark: color-mix(in srgb, var(--color-background) 80%, black 20%);
            --color-background-darker: color-mix(in srgb, var(--color-background-dark) 80%, black 20%);
            --color-background-light: color-mix(in srgb, var(--color-background) 80%, white 20%);
        
            --color-font: #EBEBEB;
            --color-font-over-primary: #EBEBEB;
        
            --color-primary: #006E5A; 
            --color-primary-light: color-mix(in srgb, var(--color-primary) 70%, white 30%);
            --color-primary-dark: color-mix(in srgb, var(--color-primary) 70%, black 30%);
            --color-accent: #08df74;
        `;
    }
    else {
        document.documentElement.style.cssText = `
            --color-background: #F2F2F2;
            --color-background-dark: color-mix(in srgb, var(--color-background) 90%, black 10%);
            --color-background-darker: color-mix(in srgb, var(--color-background-dark) 80%, black 20%);
            --color-background-light: color-mix(in srgb, var(--color-background) 80%, white 20%);
        
            --color-font: #070707;
            --color-font-over-primary: #EBEBEB;
        
            --color-primary: #009579;
            --color-primary-light: #0dcfb5;
            --color-primary-dark: #006E5A;
            --color-accent: #0A74FF; 
        `;
    }
}
