======
README
======

About:
------
lk4me (link for me) is an URL shortener developed in PHP. It is released under the Gnu Public License v3. 

It requires **no other requirement than PHP**. No database, only flat files to store URL.

Principles:
-----------
lk4me works like this :

- it takes long URLs, 
- it hashs them using sha-1,
- it takes the first 6 characters of the sha-1 digest (example : abcdef) ,
- these 6 characters ( abcdef ) became the short url (http://domain.tld/abcdef),
- the long url is stored in a flat file located under DocumentRoot/store directory. Full pathname: DocumentRoot/store/a/b/abcdef.

**Collision handling:**
In case of a collision with a short link value that has been previously generated, lk4me will:

- apply a shift by 1 character,
- and retry this shift by 1 character up to 6 times in order to get a previously unused value.

If lk4me fails to generate a not already used value after 6 tries, lk4me will declare it is unable to do it.