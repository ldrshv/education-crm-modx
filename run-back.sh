#!/bin/bash

cd ./_docker && docker stop $(docker ps -a -q) && docker compose up
