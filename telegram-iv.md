## Blog Post

~version: "2.0"

title:   //h1                                     # News Title become the first H1
?path: /blog/.*                                   # On all pages from blog section

body: //div[@class="entry-summary"]               # Body of the new article
author: //span[@class="tg-author"]                # Author name of the post

author_url: "https://www.bachecubano.com"         # URL of the author

published_date: //span[@class="tg-created"]       # Posted Date

#kicker: "kicker"
#subtitle: "subtitle"

published_date: //span[@class="tg-created"]       # Author name of the post

#description: "description"

$cover_image: //img[@class="tg-post-cover"]

site_name: "Blog Bachecubano"                     #Site Name

channel: "@elBacheChannel"                        #Channel Kind Of

image_url: //div[@class="post-thumb"]//a//img[@src]
cover: //div[@class="post-thumb"]//a//img[@src]


## Ad Post

~version: "2.0"

title:   //h1                                     # News Title become the first H1
?path: /[a-z]*/[a-z]*/[a-zA-Z0-9-]*/\d*           # On all pages from ads publish

body: //div[@id="content"]                        # Match Body content

author: //span[@class="tg-contact-name"]          # Author name of the post

author_url: "https://www.bachecubano.com"         # URL of the author

published_date: //span[@class="tg-created-timestamp"]       # Posted Date

#kicker: "kicker"
#subtitle: "subtitle"

#description: "description"

$cover_image: //img[@class="tg-post-cover"]

site_name: "Bachecubano"                     #Site Name

channel: "@elBacheChannel"                        #Channel Kind Of

image_url: //img[@class="tg-image"][@src]
cover: //img[@class="tg-image"][@src]