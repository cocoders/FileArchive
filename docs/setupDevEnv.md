# Setup dev environment

The project facilitates the creation of an dev environment by using Vagrant with Puppet (by puphpet.com).
You need to install *vagrant in version >= 1.6.0*
Virtual machine OS is Ubuntu Server 14.04 machine.

Then you can setup machine by using such command from project root:

```bash
vagrant up --provision
```

*Our configuration uses NFS synced folder!*
Please read [following vagrant documentation entry](http://docs.vagrantup.com/v2/synced-folders/nfs.html) in case of problems.
Windows user should probably use [winnfsd](https://github.com/GM-Alex/vagrant-winnfsd) vagrant plugin

Command to login into virtual machine (from project root):

```bash
vagrant ssh
```
