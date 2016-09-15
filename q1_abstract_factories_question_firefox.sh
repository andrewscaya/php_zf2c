#!/bin/bash
cd q1_abstract_factories_question
( cmdpid=$BASHPID; (sleep 60; kill $cmdpid) & exec php -S localhost:8181 -t public ) > /dev/null 2>&1 &
sleep 2
#if [ "$(uname)" == "Darwin" ]; then
    # Do something under Mac OS X platform        
#elif [ "$(expr substr $(uname -s) 1 5)" == "Linux" ]; then
    # Do something under GNU/Linux platform
#elif [ "$(expr substr $(uname -s) 1 10)" == "MINGW32_NT" ]; then
    # Do something under Windows NT platform
#fi
firefox localhost:8181
