#!/bin/bash

for tbl in `psql -qAt -c "select tablename from pg_tables where schemaname = 'public';" uh19db2` ; do  psql -c "select setval('${tbl}_id_seq', (select max(id) from $tbl))
 " uh19db2 ; done
