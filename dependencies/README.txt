Third-party maintained components that are not easily covered by other tools, or may cause breakage if changed elsewhere.

Do not include:
 * apt-get or yum installable stuff (unless too breakable) - put this into scripts/install/*.sh
 * pip or php-pear installable stuff (put these into a scripts/* recipe)
 * Javascript libraries that are (e.g.) open-source and downloaded/unpacked into htdocs/js... Consider making these a <script> tag to an external reference, e.g. Google hosts a lot of of JS libraries including a URL for a specific version number
 * Large binaries such as matlab installs, JRE/JVM, .dpkg or .rpm files

DO include:
 * obscure scripts and libraries (php, python, java, etc) that are used by any of the scripts or includes but not package-managed
 * a snapshot of any libraries that are not in htdocs or included in lib/
 * small compiled binaries if these are complex to generate and change infrequently (e.g. not per environment or code revision)
 * tools used by scripts to get their work done - consider putting these in the 'env' project if they are useful to anyone
