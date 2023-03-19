<?xml version='1.0' encoding='UTF-8'?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($posts as $post)
    <url>
        <loc>{{ $post['url'] }}</loc>
        <lastmod>{{ $post['updated_at'] }}</lastmod>
    </url>
    @endforeach
</urlset>