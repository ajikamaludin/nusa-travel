<?xml version='1.0' encoding='UTF-8'?>
    <sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($pages as $page)
        <sitemap>
            <loc>{{ route('sitemap') }}?page={{ $page }}</loc>
        </sitemap>
    @endforeach
</sitemapindex>