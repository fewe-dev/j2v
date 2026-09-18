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
composer phar
```

### Binary ###

**Install**
```bash
composer global require phpacker/phpacker
```
**Compile**
```bash
composer bin
```

### Debian package ###

**Compile**
```bash
composer deb
```
