module.exports = {
    purge: [],
    darkMode: false, // or 'media' or 'class'
    theme: {
        container: {
            center: true,
        },
        minHeight: {
            '4':'4rem'
        }
     
    },
    variants: {
        width: ["responsive", "hover", "focus"],
        height: ["responsive", "hover", "focus"],
        boxShadow:["responsive", "hover", "focus"]

    },
    plugins: [],
}
