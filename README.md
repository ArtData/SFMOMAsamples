SFMOMA Collection API
=====================

Version 0.5.x-alpha

### Authentication

The Collection API uses HTTP Basic Authentication.


### Collection API Endpoints

Presently API responss are in JSON format.


#### Root

https://api.sfmoma.org/collection/



#### JSON-P

https://api.sfmoma.org/collection/?callback=myFunction


#### Artists

https://api.sfmoma.org/collection/artists/ returns a paginated array of Artist
documents.

A specific artist document can be returned using any of the artist name slug,
an artist `artist_id`, or the unique document `_id`.

Exmaple name slugs might be `Agnes_Martin` or `Pablo_Picasso`

https://api.sfmoma.org/collection/artists/Agnes_Martin
https://api.sfmoma.org/collection/artists/Pablo_Picasso

Their corresponding `artist_id` returns the same documents,
https://api.sfmoma.org/collection/artists/856
https://api.sfmoma.org/collection/artists/867

As does the unique document `_id` for each,
https://api.sfmoma.org/collection/artists/54189f35a45f8874c6000102
https://api.sfmoma.org/collection/artists/54189f35a45f8874c600010d

With future data migrations the unique document `_id` *might* change where as
`artist_id` and artist name slugs will persist.


#### Artworks

https://api.sfmoma.org/collection/artworks/ returns a paginated array of Artworks.

A specific artwork document can be returned using any either its `artwork_id`,
or the unique document `_id`. The current data migration does not contain any
artwork name slugs.

https://api.sfmoma.org/collection/artworks/4351
https://api.sfmoma.org/collection/artworks/5418a96ea45f887a02000ff1


### Sort

https://api.sfmoma.org/collection/artists/?order=birth_date
https://api.sfmoma.org/collection/artists/?order=birth_date,death_date

https://api.sfmoma.org/collection/artworks/?order=artwork_id



### Pagination

The current version of the API includes custom header params for pagination.
(The next version will default to using a response envelope which includes the
pagination parameters in the response body though can be configured to respond
without using an envelope.

	X-Total-Pages
	X-Per-Page
	X-Total
	X-Prev-Page
	X-Offset
	X-Page
	X-Next-Page


https://api.sfmoma.org/collection/artworks/?per_page=100,page=2
https://api.sfmoma.org/collection/artworks/?per_page=100,page=1,offset=100


### Partial Responses

The `fields` query parameter acccepts comma separated list of top-level keys to
be included in the respons. (Speficing the fields in nested documents will be
part of a future release.)

Example:

https://api.sfmoma.org/collection/artworks/?fields=display_title,sort_artist,dimensions


### Search

Accepts a query parameter `q` to perform a a full text search, though at present
the search is limited to artwork titles.

Example:

https://api.sfmoma.org/collection/search?q=hats&max_results=10



### Swagger-Docs

The API supports Swagger generated documentation which is however in need of some
details...

https://api.sfmoma.org/collection/api-docs
