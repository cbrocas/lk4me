======
README
======

About :
-------
lk4me (link for me) is an URL shortener developed in PHP. It is released under the Gnu Public License v3. 

It requires **no other requirement than PHP**. No database, only flat files to store URL.

lk4me is used by the free (as in beer and as a speech) webservice http://lk4.me/ .

Principles :
------------
lk4me works like this :

- it takes long URLs, 
- it hashs them using sha-1,
- it takes the first 6 characters of the sha-1 digest (example : abcdef) ,
- these 6 characters ( abcdef ) became the short url (http://domain.tld/abcdef),
- the long url is stored in a flat file whose pathname is /a/b/abcdef

