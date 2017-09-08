# mkpasswd.php is a `mkpasswd -m sha-512` in php (5.6+/7.x+)
This is an implementation of `mkpasswd -m sha-512` in PHP.
For those poor souls that don't have mkpasswd.c or have `crypt()` library broken on their systems and cannot use Python implementation (I am looking at you OSX/macOS), or generally dislike Python or Ruby and would rather use PHP.

## Prerequisites
PHP 5.6 or 7.0+ installed on your system.

## Usage:
If not already downloaded, download the script and make it executable.

```
chmod +x ./mkpasswd.php
```

Run it
```
./mkpasswd.php
```

The script will ask you for your password first, then for the confirmation of the password, and will generate SHA-512 hash with salt, that is ready for copy/pasting into your `/etc/shadow`.

e.g:

```
$6$yAABw15fB8n$Fc4451LE5/JP3R1Y3lQwGz4yva/x.C/v19MMrYfpsVE1s8aAGLqmDpCMKqAg/gT2PaK428smreEszKYUXcgkn1
```


## TODO
Maybe add other hashing options.

WARNING: The script is designed to work in non-destructive way. But you are using it at your own peril. I cannot be liable for Earth standing still, your cat getting possessed or your computer bursting in flames.

copyleft. (CC BY-SA 4.0) Do whatever you want with it.
