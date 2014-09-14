# Installation

Project using composer dependency manager.
Composer is pre installed at Vagrant machine.
To install all needed dependencies you should do following steps:

```bash
leszek@localhost:~/projects/FileArchive$ vagrant ssh #login to vagrant machine
[vagrant@packer-virtualbox-iso]$ cd /var/www;
[vagrant@packer-virtualbox-iso]$ composer install --dev #this will take a moment
```

All needed packages should be installed afterwards.