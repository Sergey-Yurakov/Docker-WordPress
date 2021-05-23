(function(){
    var body = document.body;
    var switchers = document.getElementsByClassName('dark-mode-widget');
    /**
     * Click on dark mode icon. Add dark mode classes and wrappers. 
     * Store user preference through sessions
     */
    for ( i = 0; i < switchers.length; i++) {
        switchers[i].addEventListener("click", function() {
            //If Light Mode is the default theme mode
            if (pliska_theme_mode_object[0]=='light'){
                if (!this.classList.contains('js-toggle--checked')) {
                    this.classList.add('js-toggle--checked');
                    body.classList.add('dark-mode');
                    //Save user preference in storage
                    localStorage.setItem('pliskaNightMode', 'true');
                } else {
                    this.classList.remove('js-toggle--checked');
                    body.classList.remove('dark-mode');
                    setTimeout(function() {
                        localStorage.removeItem('pliskaNightMode');
                    }, 100);
                }
            }
    
             // if Dark Mode is default theme mode
             if (pliska_theme_mode_object[0]=='dark') {
                    if (this.classList.contains('js-toggle--checked')) {
                        this.classList.remove('js-toggle--checked');
                        body.classList.remove('dark-mode');
                        localStorage.setItem('pliskaLightMode', 'true')
                       //Save user preference in storage
                   } else {
                       this.classList.add('js-toggle--checked');
                       body.classList.add('dark-mode');
                       setTimeout(function() {
                        localStorage.removeItem('pliskaLightMode');
                    }, 100);
                   }
             }
        
        })
    }

     //Check Storage. Keep user preference on page reload
     if (localStorage.getItem('pliskaNightMode')) {
        for ( i = 0; i < switchers.length; i++) {
            switchers[i].classList.add('js-toggle--checked');
            body.classList.add('dark-mode');
        }
     }

     if (localStorage.getItem('pliskaLightMode')) {
        for ( i = 0; i < switchers.length; i++) {
            switchers[i].classList.remove('js-toggle--checked');
            body.classList.remove('dark-mode');
        }
     }

}());