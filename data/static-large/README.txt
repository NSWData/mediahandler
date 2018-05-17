Large objects (PDFs etc) that are centrally updated but not kept with code.

These are normally synced into place (e.g. rsync, or part of a deployment script)

The web server should ideally read these files as file handles, rather than including them directly via Apache.

If this is difficult, then sync them into htdocs/data or htdocs/cache etc and make sure these are in .gitignore
