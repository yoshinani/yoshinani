#!/usr/bin/env bash
cd `dirname $0`
path=$(pwd)
homestead=$HOME/homestead

# Generate when Homestead.yaml does not exist
if [ ! -e ${path}/Homestead.yaml ]; then
  cp ${path}/Homestead/Homestead.yaml ${path}/Homestead.yaml
  sed -i '' "s:ApplicationPath:${path}:g" ${path}/Homestead.yaml
fi

# When Homestead.yaml does not exist
if [ ! -e ${homestead} ]; then
  # When the argument does not exist
  if [ "$1" = "" ]; then
    echo 'Absolute path is required for argument'
    exit
  fi
  # When Homestead does not exist
  if [ ! -e $1 ]; then
    echo 'Homestaead does not exist'
    exit
  fi
  ${homestead}=$1
fi

# Generate when Homestead.yaml does not exist
if [ ! -e ${homestead}/Homestead.yaml ]; then
  cp ${path}/Homestead.yaml ${homestead}
fi

echo 'Setup succeeded'