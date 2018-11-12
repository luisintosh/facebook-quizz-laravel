<footer class="footer mt-sm-4">
    <div class="container text-center">
        <!-- Description -->
        <div class="footer-description">
            <p class="mb-4 text-muted">
                <small>Para poner a prueba todo lo que conoces y divertirnos un poco, creamos Facebook Quizzes para que
                    descubras cosas interesantes sobre religión, música, películas, TV, trabajos y mucho más. Cuando
                    necesites matar el tiempo en clase, en el trabajo o hasta en la casa. OKOK tiene para tí una larga
                    lista de juegos para divertirte. Selecciona un quiz y asombrate con los resultados tan inesperados
                    que nuestro sistema puede lanzarte. Se parte de los quizzes que todo mundo esta jugando.</small>
            </p>
            <p>
                <small>Te gusta nuestro contenido? Ayúdanos a compartirlo y síguenos en facebook,  donde descubrirás algo
                    nuevo cada día.</small>
            </p>
        </div>
        <!-- Copyrights-->
        <div class="copyrights">
            <p class="copyrights-text mb-0">Desarrollado por <a href="https://www.tequilapps.com" target="_blank" class="copyrights-link">Tequilapps</a></p>
        </div>
    </div>
</footer>

<div id="fb-root"></div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}?v={{ filemtime( resource_path('js/app.js') ) }}"></script>
@stack('scripts')
<!-- Facebook -->
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v3.2&appId={{ env('FACEBOOK_CLIENT_ID') }}&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
<!-- Addthis.com -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid={{ \App\Settings::get('addthis_code') }}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-128588500-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', '{{ \App\Settings::get('google_analytics') }}');
</script>
