#!/bin/bash
sed 's/us\.archive/it\.archive/' -i /etc/apt/sources.list

aptitude update
aptitude install git ruby-dev libaugeas-ruby --assume-yes

PUPPET_DIR=/etc/puppet

if [ ! -d "$PUPPET_DIR" ]; then
    mkdir -p "$PUPPET_DIR"
fi

cp /vagrant/vagrant/puppet/Puppetfile $PUPPET_DIR

if [ `gem list | grep librarian | wc -l` -eq 0 ]; then
  gem install puppet --version '<4.0' librarian-puppet
  cd $PUPPET_DIR && librarian-puppet install --clean
else
  cd $PUPPET_DIR && librarian-puppet update
fi
