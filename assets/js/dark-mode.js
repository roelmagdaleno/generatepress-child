window.rmr = {
    darkMode: {
        add: function () {
            window.rmr.darkMode.toggle();

            const bodyEl = document.querySelector( 'body' );

            if ( bodyEl.classList.contains( 'dark-mode' ) ) {
                localStorage.rmrIsDarkMode = true;
                return;
            }

            delete localStorage.rmrIsDarkMode;
        },
        toggle: function () {
            const bodyEl   = document.querySelector( 'body' );
            const headerEl = document.querySelector( 'header' );

            if ( ! bodyEl ||! headerEl ) {
                return;
            }

            bodyEl.classList.toggle( 'dark-mode' );
            headerEl.classList.toggle( 'dark-mode' );
        },
        init: function () {
            if ( ! localStorage.rmrIsDarkMode ) {
                return;
            }

            window.rmr.darkMode.toggle();
        }
    }
};

document.addEventListener( 'DOMContentLoaded', () => window.rmr.darkMode.init() );
