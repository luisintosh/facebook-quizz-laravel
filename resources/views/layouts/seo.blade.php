{{--HTML5--}}
<title>@yield('meta_title')</title>
<meta name="description" content="@yield('meta_description')">
<meta name="robots" content="index, follow">
<meta name="author" content="{{ \App\Settings::get('site_name', 'Tequilapps') }}">

{{--OPEN GRAPH--}}
<meta property="og:type" content="game.achievement">
<meta property="og:title" content="@yield('meta_title')">
<meta property="og:description" content="@yield('meta_description')" />
<meta property="og:url" content="@yield('meta_url')">
<meta property="og:image" content="@yield('meta_image')">
<meta property="game:points" content="100">

{{--TWTITTER CARD--}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('meta_title')">
<meta name="twitter:description" content="@yield('meta_description')">
<meta name="twitter:image" content="@yield('meta_image')">

{{--JSON-LD--}}
<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "NewsArticle",
  "headline": "@yield('meta_title')",
  "datePublished": "{{ date('Y-m-d') }}",
  "description": "@yield('meta_description')",
  "image": {
    "@type": "ImageObject",
    "url": "@yield('meta_image')"
  },
  "author": "{{ \App\Settings::get('site_name', 'Tequilapps') }}",
  "articleBody": "@yield('meta_description')"
}
</script>
