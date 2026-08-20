# JSON 2 VAR

This is a simple application to convert JSON to VAR format.

## Installation

### Debian

**Latest:**
```bash
cd /tmp && curl -sLO https://raw.githubusercontent.com/fewe-dev/j2v/refs/heads/master/build/linux/j2v.deb && sudo dpkg -i j2v.deb
```

**Specific version:**
```bash
cd /tmp && curl -sLO https://raw.githubusercontent.com/fewe-dev/j2v/refs/tags/1.0.0/build/linux/j2v.deb && sudo dpkg -i j2v.deb
```

## Development

### Phar ###

**Install**
```bash
composer global require humbug/box
```
**Compile**
```bash
~/.config/composer/vendor/bin/box compile
```

### Binary ###

**Install**
```bash
composer global require phpacker/phpacker
```
**Compile**
```bash
~/.config/composer/vendor/bin/phpacker build all --src=./build/j2v.phar --dest=./build/
```

### Debian package ###

**Compile**
```bash
cd build/linux && mkdir -p debian/usr/bin && cp linux-x64 debian/usr/bin/j2v && dpkg-deb --build debian j2v.deb && rm -rf debian/usr && cd ../..
```
