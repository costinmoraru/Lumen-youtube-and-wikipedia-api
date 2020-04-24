# Assignment

In this exercise your task consists of talking to two different data sources, merging the data
into a coherent response and returning it with a couple of niceties.

Task requirements
1. Lumen 6.*
1. php 7.4
1. Caching the youtube result with Redis

Apart from that you have the freedom to use any library. It is recommended you use
Lumen/Laravel functionality whenever possible.

Going on to the task at hand:
1. You need to fetch from the Youtube api the most popular videos for the following
countries: uk,nl,de,fr,es,it,gr. Important information are the description as well as the
normal and high resolution thumbnails. Calls should be done asyncronously if possible. Take
care not to trigger rate limits any way you see fit.
1. For the above countries, fetch from the Wikipedia API the initial paragraphs of their
wikipedia articles has. (before the sections)
1. Enrich the per country youtube results with the foreword that was collected from
Wikipedia
1. Return the results in json. You should be able to ask for offset and page size (countries
per page)
